<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingData;
use App\Models\Draft;
use App\Models\DraftData;
use App\Jobs\BookingEmailJob;
use App\Mail\BookingMail;
use App\Models\MailTemplate;
use App\Models\Contact;
use App\Models\Notification;
use Exception;
use Session;
use Auth;
use DB;
use Plivo\RestClient;

class BookingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $departments = Department::all();
        $foreman = User::whereHas("roles", function ($q) {
            $q->where("name", "Foreman");
        })->get();
        return view('booking', compact('departments', 'foreman'));
    }

    public function store(Request $request)
    {

        $booking = new Booking;
        $booking->address = $request->get('address');
        $booking->floor_area = $request->get('floor_area');
        $booking->floor_type = $request->get('floor_type');
        $booking->notes = $request->get('notes');
        $booking->foreman_id = $request->get('foreman');
        $request_status=$request->get('status');
        $files = [];
        if (!empty($request->get('existing_file'))) {
            $files = $request->get('existing_file');
        }
        if ($request->hasfile('file_upload')) {
            foreach ($request->file('file_upload') as $file) {
                $file_name = $file->getClientOriginalName();
                $name = time() . rand(1, 100) . '-' . $file_name;
                $file->move('images', $name);
                $files[] = $name;
            }
        }
        $booking->file = $files;
        $booking->save();

        $booking_id = $booking->id;
        $requested_date = $request->get('date');
        foreach ($request->get('department') as $key => $val) {
            $book_array = array(
                'department_id' => $key,
                'contact_id'  => $val,
                'date' => @$requested_date[$key],
                'booking_id' => $booking_id
            );
            echo $key . "<br>";
            if ($key == '2') {
                $book_array['status'] = 1;
            }

            if(empty($request_status[$key]))
            {
                $book_array['status'] = 2;

            } 
            BookingData::create($book_array);
        }

        if (!empty($request->get('draft_id'))) {
            $draft_id = $request->get('draft_id');
            Draft::find($draft_id)->delete();
            DraftData::where(array('draft_id' => $draft_id))->delete();
        }
        $notification = new Notification();
        $notification->foreman_id = $request->get('foreman');
        $notification->notification = '<b>' . ucfirst(Auth::user()->name) . '</b> created a new booking for: <b>' . $request->get('address') . '</b>';
        $notification->booking_id = $booking_id;
        $notification->save();
        return redirect()->to('booking/' . $booking_id)->with('succes_msg', 'Your booking has been saved.Please check mail templates');
    }

    public function booking($id)
    {
        $booking = Booking::find($id);
        $mail = MailTemplate::where(array('status' => 1))->get();
        return view('update_mail', compact('booking', 'mail'));
    }

    public function test_msg(Request $request)
    {
        $account_sid = \config('const.plivo_sid');;
        $auth_token = \config('const.plivo_token');
        $msg = '';
        if (!empty($request->get('from')) && !empty($request->get('to'))) {
            $client = new RestClient($account_sid,$auth_token);
            try {
                $message_created = $client->messages->create(
                    [  
                          "src" => $request->get('from'),
                          "dst" => $request->get('to'),
                          "text"  =>"Hello, world!",
                       ]
                  );
                $msg = 'success';
            } catch (Exception $e) {
                $msg = $e->getMessage();
            }
        }
        return view('test_mail', compact('msg'));
    }


    public function send_mail(Request $request)
    {
        $account_sid = \config('const.twilio_sid');;
        $auth_token = \config('const.twilio_token');


        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

        // A Twilio number you own with SMS capabilities
        $twilio_number = "+16209129397";

        $client = new RestClient("<auth_id>","<auth_token>");

        $mail_data = $request->get('mail_data');
        if (!empty($mail_data)) {
            foreach ($mail_data as $res) {
                $booking_data = BookingData::find($res['booking_id']);
                $booking_id = $booking_data->booking_id;
                $contact = Contact::find($booking_data->contact_id);
                if ($contact->sms_enabled == '1' && !empty($contact->contact)) {

                    try {
                        $output_string = preg_replace('/(<[^>]*) style=("[^"]+"|\'[^\']+\')([^>]*>)/i', '$1$3', $res['body']);
                        $output_string = preg_replace("/<a.+href=['|\"]([^\"\']*)['|\"].*>(.+)<\/a>/i", '\1', $output_string);
                        $res = $client->messages->create(
                            // Where to send a text message (your cell phone?)
                            $contact->contact,
                            array(
                                'from' => $twilio_number,
                                'body' => preg_replace("/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($output_string))))
                            )
                        );
                    } catch (Exception $e) {
                        $e->getMessage();
                    }
                } else {
                    $details['to'] = $contact->email;
                    $details['name'] = $contact->title;
                    $details['url'] = 'testing';
                    $details['subject'] = $res['subject'];
                    $details['body'] = $res['body'];
                    dispatch(new BookingEmailJob($details));
                }
            }
            Booking::where('id', $booking_id)
                ->update([
                    'mail_sent' => 1
                ]);
        }


        return array("success" => true);
    }

    public function reply($id)
    {
        $booking_data_id = base64_decode($id);
        $booking_data = BookingData::find($booking_data_id);
        if ($booking_data->status != '0') {
            $status = $booking_data->status;
            return view('booking_confirmation', compact('status'));
        }
        return view('email_reply', compact('booking_data'));
    }

    public function admin_reply($id)
    {
        $booking_data_id = base64_decode($id);
        $booking_data = BookingData::find($booking_data_id);
        if ($booking_data->status != '2') {
            return 'Link has been used...';
        }
        return view('admin_email_reply', compact('booking_data'));
    }

    public function reply_confirmation(Request $request)
    {
        $id = $request->get('booking_data_id');
        $booking_data = BookingData::find($id);
        $booking = $booking_data->booking;
        $contact = $booking_data->contact;
        $department = $booking_data->department;
        $update_data['status'] = $request->get('confirm');
        if ($request->get('confirm') == 2) {
            $html = '';
            $address = $booking->address;
            $b_date = date("d-m-Y h:i A", strtotime($booking_data->date));
            $html .= "<p>There is a date/time change request for the following booking.</p>";
            $html .= "<p>Address : <strong><u>$address</u></strong></p>";
            $html .= "<p>Department : <strong><u>$department->title</u></strong></p>";
            $html .= "<p>Contact : <strong><u>$contact->title</u></strong></p>";
            $html .= "<p>Date : <strong><u>$b_date</u></strong></p>";
            $html .= "<br><p>Contact has suggested below alternate time</p>";
            if (!empty($request->get('date1'))) {
                $html .= "<p>Alternate DateTime 1 : " . $request->get('date1') . "</p>";
                $update_data['new_date'][] = $request->get('date1');
            }
            if (!empty($request->get('date2'))) {
                $html .= "<p>Alternate DateTime 2 : " . $request->get('date2') . "</p>";
                $update_data['new_date'][] = $request->get('date2');
            }
            if (!empty($request->get('date3'))) {
                $html .= "<p>Alternate DateTime 3 : " . $request->get('date3') . "</p>";
                $update_data['new_date'][] = $request->get('date3');
            }
            $enc_key = base64_encode($booking_data->id);
            $url = URL("admin-reply/$enc_key");
            $html .= "<a href='" . $url . "' style='border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
	user-select: none;
	text-decoration: none !important;
    line-height: 1.5;
    border-radius: 0.25rem;color:#fff;background-color: #172b4d;border-color: #172b4d;'>CLICK HERE FOR ALTERNATE SCHEDULE </a>";
            $details['to'] = \config('const.admin1');
            $details['subject'] = 'Booking Cancelled';
            $details['body'] = $html;
            dispatch(new BookingEmailJob($details));
            $details['to'] = \config('const.admin2');
            dispatch(new BookingEmailJob($details));
            $notification = new Notification();
            $notification->foreman_id = $booking->foreman_id;
            $notification->notification = '<b>' . $department->title . '</b> has request date change for booking <b>' . $booking->address . '</b>,Please check email.';
            $notification->booking_id = $booking->id;
            $notification->save();
        }else
        {
            $notification = new Notification();
            $notification->foreman_id = $booking->foreman_id;
            $notification->notification = '<b>' . $department->title . '</b> has accept the requested date for booking <b>' . $booking->address . '</b>';
            $notification->booking_id = $booking->id;
            $notification->save();
        }
        BookingData::where('id', $id)
            ->update($update_data);
    }
    public function admin_reply_confirmation(Request $request)
    {

        if ($request->get('confirm') == 1) {
            $id = $request->get('booking_data_id');
            $booking_data = BookingData::find($id);
            BookingData::where('id', $id)
                ->update(array('status' => 1, 'date' => $booking_data->new_date[$request->get('alternate_date')]));
        }

        if ($request->get('confirm') == 0) {

            $id = $request->get('booking_data_id');
            BookingData::where('id', $id)
                ->update(array('status' => 0, 'date' => $request->get('date')));
            $booking_data = BookingData::find($id);
            $booking = $booking_data->booking;
            $email = $booking_data->contact->email;
            $html = '';
            $address = $booking->address;
            $b_date = date("d-m-Y h:i A", strtotime($booking_data->date));
            $html .= "<p>Boxit has requested revised time for following booking.</p>";
            $html .= "<p>Address : <strong><u>$address</u></strong></p>";
            $html .= "<p>Floor Area : <strong><u>$booking->floor_area</u></strong></p>";
            $html .= "<p>Floor Type : <strong><u>$booking->floor_type</u></strong></p>";
            $html .= "<p>Revised Date : <strong><u>$b_date</u></strong></p>";
            $enc_key = base64_encode($booking_data->id);
            $url = URL("reply/$enc_key");
            $html .= "<a href='" . $url . "' style='border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
	user-select: none;
	text-decoration: none !important;
    line-height: 1.5;
    border-radius: 0.25rem;color:#fff;background-color: #172b4d;border-color: #172b4d;'>Click here to approve or make a change request</a>";
            $html .= '<br>Thanks,<br>
    Jules,<br>
    BOXIT Sales<br>
    <a href="mailto:admin@boxitfoundations.co.nz">admin@boxitfoundations.co.nz</a>
    <br>
    <a href="https://boxitfoundations.co.nz">https://boxitfoundations.co.nz</a><br>';
            $details['to'] = $email;;
            $details['subject'] = 'Booking Revised';
            $details['body'] = $html;
            dispatch(new BookingEmailJob($details));
        }
    }


    public  function daysInMonth($iMonth, $iYear)
    {
        return cal_days_in_month(CAL_GREGORIAN, $iMonth, $iYear);
    }
    public function monthly_calender(Request $request)
    {
        $year = $request->get('year');
        $requested_month = $request->get('month') + 1;
        $firstDay = $dayofweek = date('w', strtotime($year . "-" . $requested_month));
        $date = 1;
        $html = '';
        for ($i = 0; $i < 6; $i++) {
            // creates a table row
            $html .= '<div class="foo_monthly pd-boxes">';

            //creating individual cells, filing them up with data.
            for ($j = 0; $j < 7; $j++) {
                if ($i === 0 && $j < $firstDay) {
                    $html .= '<div class="booked_div_monthly"><span class="week_count"></span></div>';
                } else if ($date > $this->daysInMonth($requested_month, $year)) {
                    $html .= '<div class="booked_div_monthly"><span class="week_count"></span></div>';
                    continue;
                } else {
                    $current = strtotime(date("Y-m-d"));
                    $today_date    = strtotime("$year-$requested_month-$date");
                    $datediff = $today_date - $current;
                    $class = '';
                    if ($datediff == 0) {
                        $class = " active-day-month";
                    }
                    $inner_html = '<span data-id="" class="week_count' . $class . '">' . $date . '</span>';
                    $booking_date = date('Y-m-d', strtotime($year . "-" . $requested_month . "-" . $date));
                    $booking_datas = BookingData::whereDate('date', '=', $booking_date)
                        ->get();
                    foreach ($booking_datas as $booking_data) {
                        if (!empty($booking_data->booking)) {
                            $address = implode(' ', array_slice(explode(' ', $booking_data->booking->address), 0, 3));
                            $dep = $booking_data->department->title;
                            $style = '';
                            switch ($booking_data->status) {
                                case '0':
                                    $class = "orange_bullet monthly_booking";
                                    $style = 'color:' . $booking_data->booking->pending_text_color;
                                    break;
                                case '1':
                                    $class = "green_bullet monthly_booking";
                                    $style = 'color:' . $booking_data->booking->confirm_text_color;
                                    break;
                                case '2':
                                    $class = "red_bullet monthly_booking";
                                    break;
                                default:
                                    $class = "monthly_booking";
                            }
                            $b_id = $booking_data->booking_id;
                            $inner_html .= "<span class='$class show_booking' style='$style' data-id='" . $b_id . "'>$dep:$address</span>";
                        }
                    }

                    $html .= '<div class="booked_div_monthly">' . $inner_html . '</div>';
                    $date++;
                }
            }

            $html .= '</div>';
        }
        echo  $html;
    }

    public function calender(Request $request)
    {
        $dates = $request->get('dates');
        $year = $request->get('year');
        $foreman_id = $request->get('foreman_id');
        $requested_month = $request->get('month') + 1;
        $html = '';
        foreach ($dates as $date) {
            $html .= '<div class="foo pd-boxes">';
            if ($date['thisMonth'] != 1) {
                if ($date['day'] >= 25)
                    $month = $requested_month - 1;
                else
                    $month = $requested_month + 1;
            } else {
                $month = $requested_month;
            }
            $booking_date = date('Y-m-d', strtotime($year . "-" . $month . "-" . $date['day']));

            $department_id = array(2, 3, 4, 5, 6, 7, 8, 9, 10);
            foreach ($department_id as $id) {
                $booking_data = BookingData::where(array('department_id' => $id))->whereHas('booking', function ($query) use ($foreman_id) {
                    if (!empty($foreman_id))
                        $query->where('foreman_id', $foreman_id);
                })->whereDate('date', '=', $booking_date)
                    ->get();
                $b_id = '';
                $html .= "<div class='booked_div'>";
                foreach ($booking_data as $boo) {
                    $address = implode(' ', array_slice(explode(' ', $boo->booking->address), 0, 3));
                    $style = '';
                    switch ($boo->status) {
                        case '0':
                            $class = "orange_box show_booking";
                            $style = 'background: ' . $boo->booking->pending_background_color . ';color: ' . $boo->booking->pending_text_color . ' !important;border-left: 1px solid ' . $boo->booking->pending_text_color . ';border-bottom: 1px solid ' . $boo->booking->pending_text_color . ';';
                            break;
                        case '1':
                            $class = "green_box show_booking";
                            $style = 'background: ' . $boo->booking->confirm_background_color . ';color: ' . $boo->booking->confirm_text_color . ' !important;border-left: 1px solid ' . $boo->booking->confirm_text_color . ';border-bottom: 1px solid ' . $boo->booking->confirm_text_color . ';';
                            break;
                        case '2':
                            $class = "red_box show_booking";
                            break;
                        default:
                            $class = "show_booking";
                    }
                    $b_id = $boo->booking_id;
                    $html .= "<span class='$class' style='$style' data-id='" . $b_id . "'>$address</span>";
                }
                $html .= "</div>";
            }
            $html .= "</div>";
        }
        return $html;
    }

    public function modal_data(Request $request)
    {
        $id = $request->get('id');
        $booking = Booking::find($id);
        $booking_data = $booking->BookingData;
        $html = '<div class="row">
								<div class="col-md-6" style="border-right: 1px solid #E7E7E7;">
									<div class="pods confirmed-txt pop-flex">
										<p>Foreman</p>
										<span>' . ucfirst($booking->foreman->name) . '</span>
									</div>';
        foreach ($booking_data->slice(1, 4) as $res) {
            $booking_date = $res->date;
            $title = $res->department->title;
            switch ($res->status) {
                case '0':
                    $class = "pending-txt";
                    $status = "Pending";
                    break;
                case '1':
                    $class = "confirmed-txt";
                    $status = "Confirmed";
                    break;
                case '2':
                    $class = "cancelled-txt";
                    $status = "On hold";
                    break;
                default:
                    $class = "";
                    $status = "";
            }

            $html .= '<div class="steel  pop-flex ' . $class . '">
										<p>' . $title . '</p>
										<span>' . date('d/m/Y h:i A', strtotime($booking_date)) . ' - ' . $status . '</span>
									</div>
									';
        }
        $html .=        '</div><div class="col-md-6">';
        foreach ($booking_data->slice(5) as $res) {
            $title = $res->department->title;
            $booking_date = $res->date;
            switch ($res->status) {
                case '0':
                    $class = "pending-txt";
                    $status = "Pending";
                    break;
                case '1':
                    $class = "confirmed-txt";
                    $status = "Confirmed";
                    break;
                case '2':
                    $class = "cancelled-txt";
                    $status = "On hold";

                    break;
                default:
                    $class = "";
                    $status = "";
            }
            $html .= '			<div class="pods ' . $class . ' pop-flex">
										<p>' . $title . '</p>
										<span>' . date('d/m/Y h:i A', strtotime($booking_date)) . ' - ' . $status . '</span>
									</div>';
        }

        $html .= '</div></div>';

        return array('address' => $booking->address, 'floor_type' => $booking->floor_type, 'floor_area' => $booking->floor_area, 'building_company' => $booking_data[0]->department_id == '1' ? $booking_data[0]->contact->title : 'NA', 'notes' => $booking->notes != '' ? $booking->notes : 'NA', 'html' => $html);
    }

    public function save_draft(Request $request)
    {
        if(!empty($request->get('draft_id')))
        {
        $delete_id=$request->get('draft_id');
        $this->delete_draft($delete_id);
        }
        $draft = new Draft;
        $draft->address = $request->get('address');
        $draft->floor_area = $request->get('floor_area');
        $draft->floor_type = $request->get('floor_type');
        $draft->notes = $request->get('notes');
        $draft->foreman_id = $request->get('foreman');
        $files = [];
        if ($request->hasfile('file_upload')) {
            foreach ($request->file('file_upload') as $file) {
                $file_name = $file->getClientOriginalName();
                $name = time() . rand(1, 100) . '-' . $file_name;
                $file->move('images', $name);
                $files[] = $name;
            }
        }
        $draft->file = $files;
        $draft->save();

        $draft_id = $draft->id;
        $requested_date = $request->get('date');
        $request_status=$request->get('status');

        foreach ($request->get('department') as $key => $val) {
            $book_array=array(
                'department_id' => $key,
                'contact_id'  => $val,
                'date' => @$requested_date[$key],
                'draft_id' => $draft_id
            );
            if(empty($request_status[$key]))
            {
                $book_array['status'] = 2;

            } 
            DraftData::create($book_array);
        }
        Session::flash('succes_msg', 'Draft has been saved successfuly.');

        return $draft_id;
    }

    public function draft($id)
    {
        $draft = Draft::find($id);
        $departments = Department::all();
        $foreman = User::whereHas("roles", function ($q) {
            $q->where("name", "Foreman");
        })->get();
        return view('draft', compact('departments', 'foreman', 'draft'))->render();
    }

    public function drafts()
    {
        $drafts = Draft::all();
        return view('draft-list', compact('drafts'));
    }

    public function delete_draft($id)
    {
        Draft::find($id)->delete();
        DraftData::where(array('draft_id' => $id))->delete();
        return redirect()->to('drafts/')->with('succes_msg', 'Draft has been deleted successfuly.');
    }

    public function revised_date(Request $request)
    {
        $id = $request->get('booking_data_id');
        $date = $request->get('date');
        $booking_data = BookingData::find($id);
        $booking = Booking::find($booking_data->booking_id);
        $contact = Contact::find($booking_data->contact_id);
        $department = Department::find($booking_data->department_id);
        if ($request->get('confirm') == 'true') {
            $update_array = ['date' => $date, 'status' => 1];
            $html = 'Hi,<br>';
            $html .= 'Unfortunately we need to move your booking for - ' . $booking->address . '<br>';
            $old_date = date("d-m-Y", strtotime($booking_data->date));
            $old_time = date("h:i:s A", strtotime($booking_data->date));
            $html .= "<p>FROM<br>Date - $old_date<br>Time- $old_time</p>";
            $new_date = date("d-m-Y", strtotime($date));
            $new_time = date("h:i:s A", strtotime($date));
            $html .= "<p>TO<br>Date - $new_date<br>Time- $new_time</p>";
            $html .= 'Thanks,<br>
      Jules,<br>
      BOXIT Sales<br>
      <a href="mailto:admin@boxitfoundations.co.nz">admin@boxitfoundations.co.nz</a>
      <br>
      <a href="https://boxitfoundations.co.nz">https://boxitfoundations.co.nz</a><br>';
        } else {
            $enc_key = base64_encode($booking_data->id);
            $url = URL("reply/$enc_key");
            $reply_link = "<a href='" . $url . "' style='border: 1px solid transparent;
padding: 0.375rem 0.75rem;
font-size: 1rem;
user-select: none;
text-decoration: none !important;
line-height: 1.5;
border-radius: 0.25rem;color:#fff;background-color: #172b4d;border-color: #172b4d;'>Click here to approve or make a change request</a>";
            $html = 'Hi,<br>';
            $html .= 'Unfortunately we need to move your booking for - ' . $booking->address . '<br>';
            $old_date = date("d-m-Y", strtotime($booking_data->date));
            $old_time = date("h:i:s A", strtotime($booking_data->date));
            $html .= "<p>FROM<br>Date - $old_date<br>Time- $old_time</p>";
            $new_date = date("d-m-Y", strtotime($date));
            $new_time = date("h:i:s A", strtotime($date));
            $html .= "<p>TO<br>Date - $new_date<br>Time- $new_time</p>";
            if ($contact->department_id != '2') {
                $html .= '<p>' . $reply_link . '</p>';
            }
            $html .= 'Thanks,<br>
      Jules,<br>
      BOXIT Sales<br>
      <a href="mailto:admin@boxitfoundations.co.nz">admin@boxitfoundations.co.nz</a>
      <br>
      <a href="https://boxitfoundations.co.nz">https://boxitfoundations.co.nz</a><br>';

            $update_array = ['date' => $date];
            if ($contact->department_id != '2') {
                $update_array['status'] = 0;
            }
        }
        $details['to'] = $contact->email;
        $details['name'] = $contact->title;
        $details['url'] = 'testing';
        $details['subject'] = 'Booking Revised';
        $details['body'] = $html;
        dispatch(new BookingEmailJob($details));
        Session::flash('succes_msg', 'Booking date changed successfuly.');
        BookingData::where('id', $id)->update($update_array);
        $notification = new Notification();
        $notification->foreman_id = $booking->foreman_id;
        $notification->notification = '<b>' . ucfirst(Auth::user()->name) . '</b> has requested date change for: <b>' . $booking->address . '</b>';
        $notification->booking_id = $booking->id;
        $notification->save();
    }

    public function change_colors(Request $request)
    {
        $booking = Booking::find($request->get('booking_id'));
        $booking->pending_background_color = $request->get('pending_background_color');
        $booking->pending_text_color = $request->get('pending_text_color');
        $booking->confirm_background_color = $request->get('confirm_background_color');
        $booking->confirm_text_color = $request->get('confirm_text_color');
        $booking->save();
        Session::flash('succes_msg', 'Color code changed successfuly for ' . $booking->address . '.');
    }

    public function hold_project(Request $request)
    {
        $booking = BookingData::find($request->get('booking_data_id'));    
        $booking->onhold_reason = $request->get('reason');
        $booking->status = 2;
        $booking->save();
        $notification = new Notification();
        $notification->foreman_id = $booking->booking->foreman_id;
        $notification->notification = '<b>' . ucfirst(Auth::user()->name) . '</b> has put <b>' . $booking->department->title . '</b> for <b>' . $booking->booking->address . '</b> on hold';
        $notification->booking_id = $booking->booking_id;
        $notification->save();

        Session::flash('succes_msg', 'Department status successfully changed to On Hold.');
    }

    public function new_booking_email($id)
    {
        $obj = base64_decode(($id));
        $data=json_decode($obj,true);
        $date=$data['date'];
        $id=$data['id'];
        $update_array = ['date' => $date, 'status' => 0];
        BookingData::where('id', $id)->update($update_array);
        $bookingdata = BookingData::find($id);
        $booking=$bookingdata->booking;
        $mail = MailTemplate::where(array('status' => 1,'department_id'=>$bookingdata->department_id))->get();
        return view('new_booking_mail', compact('booking', 'mail'));

    }
}
