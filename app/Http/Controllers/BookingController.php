<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingData;
use App\Models\Draft;
use App\Models\DraftData;
use App\Models\StaffLeave;
use App\Jobs\BookingEmailJob;
use App\Models\foremanNote;
use App\Mail\BookingMail;
use App\Models\MailTemplate;
use App\Models\Leave;
use App\Models\Contact;
use App\Models\Notification;
use Exception;
use Session;
use Auth;
use Mail;
use MobileDetect;
use Twilio\Rest\Client;
use Carbon\Carbon;

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
        $departments = Department::with(["contacts" => function ($q) {
            $q->orderBy('title', 'ASC');
        }])->get();

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
        $booking->bcn = $request->get('bcn');
        $booking->foreman_id = $request->get('foreman');
        $request_status = $request->get('status');
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
            if ($key != 7) {
                $book_array = array(
                    'department_id' => $key,
                    'contact_id'  => $val,
                    'date' => @$requested_date[$key],
                    'booking_id' => $booking_id
                );


                if (empty($request_status[$key])) {
                    $book_array['status'] = 2;
                }
                BookingData::create($book_array);
            } else {
                if (is_array($val)) {
                    foreach ($val as $serk => $serv) {
                        $book_array = array(
                            'department_id' => $key,
                            'contact_id'  => $serv,
                            'date' => @$requested_date[$key][$serk],
                            'service' => $serk,
                            'booking_id' => $booking_id
                        );
                        BookingData::create($book_array);
                    }
                } else {
                    $book_array = array(
                        'department_id' => $key,
                        'contact_id'  => $val,
                        'date' => @$requested_date[$key],
                        'booking_id' => $booking_id
                    );
                    BookingData::create($book_array);
                }
            }
        }

        $booking_data = BookingData::where('booking_id', $booking_id)->get();


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
        $account_sid = \config('const.twilio_sid');;
        $auth_token = \config('const.twilio_token');
        $msg = '';
        if (!empty($request->get('from')) && !empty($request->get('to'))) {
            $client = new Client($account_sid, $auth_token);
            try {
                $res = $client->messages->create(
                    // Where to send a text message (your cell phone?)
                    $request->get('to'),
                    array(
                        'from' => $request->get('from'),
                        'body' => 'test'
                    )
                );
                $msg = 'success';
            } catch (Exception $e) {
                $msg = $e->getMessage();;
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

        $client = new Client($account_sid, $auth_token);

        $mail_data = $request->mail_data;

        if (!empty($mail_data)) {
            foreach ($mail_data as $k => $res) {
                $booking_data = BookingData::find($res['booking_id']);
                $booking_id = $booking_data->booking_id;

                if ($booking_data->department_id == '5' || $booking_data->department_id == '6' || $booking_data->department_id == '7') {
                    $details = [];
                    $department = $booking_data->department->title . ($booking_data->service != '' ? ' (' . $booking_data->service . ')' : '');
                    $email_body = "Hi,<br>";
                    $email_body .= "This is a reminder to check if we have the report for <b>$department</b> at <b>" . $booking_data->booking->address . "</b>.";
                    $email_body .= '<br><p style="display:none">Project ID #' . $booking_id . '</p>Thank You,<br><br><img src="https://boxit.staging.app/img/logo2581-1.png" style="width:75px;height:30px" class="mail-logo" alt="Boxit Logo">';
                    $details['to'] = \config('const.admin1');
                    $details['address'] = $booking_data->booking->address;
                    $details['subject'] = 'Booking Cancelled';
                    $details['body'] = $email_body;
                    dispatch(new BookingEmailJob($details))->delay(Carbon::parse($booking_data->date)->addDays(1));
                    $details = [];
                }

                $contact = Contact::find($booking_data->contact_id);
                if ($contact->sms_enabled == '1' && !empty($contact->contact) && !empty($res['sms_text'])) {

                    try {
                        $output_string = $res['sms_text'];
                        $enc_key = base64_encode($booking_data->id);
                        $output_string .= "\nReply to this SMS will be charged";
                        $res = $client->messages->create(
                            // Where to send a text message (your cell phone?)
                            $contact->contact,
                            array(
                                'from' => $twilio_number,
                                'body' => $output_string
                            )
                        );
                    } catch (Exception $e) {
                        $e->getMessage();
                    }
                } else {
                    if (empty($contact->email))
                        continue;
                    $attachement_files = [];
                    if (isset($res['files'])) {
                        foreach ($res['files'] as $file) {
                            $file_name = $file->getClientOriginalName();
                            $name = time() . rand(1, 100) . '-' . $file_name;
                            $file->move('attachment', $name);
                            $attachement_files[] = public_path('attachment/' . $name);
                        }
                    }
                    $details['to'] = $contact->email;
                    $details['name'] = $contact->title;
                    $details['url'] = 'testing';
                    $details['subject'] = $res['subject'];
                    $details['body'] = $res['body'];
                    $details['files'] = $attachement_files;
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
            return view('booking_confirmation', compact('status', 'booking_data_id'));
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
        $address = $booking->address;
        $b_date = date("d-m-Y h:i A", strtotime($booking_data->date));
        $update_data['status'] = $request->get('confirm');
        if ($request->get('confirm') == 2) {
            $html = '';
            $html .= "<p>There is a date/time change request for the following booking.</p>";
            $html .= "<p>Address : <strong><u>$address</u></strong></p>";
            $html .= "<p>Department : <strong><u>$department->title" . ($booking_data->service != '' ? ' (' . $booking_data->service . ')' : '') . "</u></strong></p>";
            $html .= "<p>Contact : <strong><u>$contact->title</u></strong></p>";
            $html .= "<p>Date : <strong><u>$b_date</u></strong></p>";
            $html .= "<br><p>Contact has suggested the below alternate time(s)</p>";
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
    border-radius: 0.25rem;color:#fff;background-color:red;border-color: red;'>Click here to approve or make a change request </a><br>";
            $html .= '<br><p style="display:none">Project ID #' . $booking_data->booking_id . '</p>Thank You,<br>
                Jules<br><br>
                <img src="https://boxit.staging.app/img/logo2581-1.png" style="width:75px;height:30px" class="mail-logo" alt="Boxit Logo">

                ';
            $details['to'] = \config('const.admin1');
            $details['subject'] = 'Booking Cancelled';
            $details['address'] = $booking_data->booking->address;
            $details['body'] = $html;
            dispatch(new BookingEmailJob($details));
            $notification = new Notification();
            $notification->foreman_id = 0;
            $notification->notification = '<b>' . $department->title . '</b> has request date change for booking <b>' . $booking->address . '</b>,Please check email.';
            $notification->booking_id = $booking->id;
            $notification->save();
        } else {
            $html = '';
            if ($booking_data->created_at == $booking_data->updated_at)
                $html .= "<strong><u>$contact->title</u></strong> has confirmed the following booking:";
            else
                $html .= "<p>Your date/time change has been accepted for the following booking:</p>";
            $html .= "<p>Address : <strong><u>$address</u></strong></p>";
            $html .= "<p>Department : <strong><u>$department->title" . ($booking_data->service != '' ? ' (' . $booking_data->service . ')' : '') . "</u></strong></p>";
            if ($booking_data->created_at != $booking_data->updated_at)
                $html .= "<p>Contact : <strong><u>$contact->title</u></strong></p>";
            $html .= "<p>Date : <strong><u>$b_date</u></strong></p>";
            $html .= '<br><p style="display:none">Project ID #' . $booking_data->booking_id . '</p>Thank You,<br>
                Jules<br><br>
                <img src="https://boxit.staging.app/img/logo2581-1.png" style="width:75px;height:30px" class="mail-logo" alt="Boxit Logo">

                ';
            $details['to'] = \config('const.admin1');
            $details['address'] = $address;
            $details['subject'] = 'Booking Confirmed';
            $details['body'] = $html;
            dispatch(new BookingEmailJob($details));
            $notification = new Notification();
            $notification->foreman_id = 0;
            $notification->notification = '<b>' . $department->title . '</b> has accept the requested date for booking <b>' . $booking->address . '</b>';
            $notification->booking_id = $booking->id;
            $notification->save();
        }
        BookingData::where('id', $id)
            ->update($update_data);
    }
    public function admin_reply_confirmation(Request $request)
    {
        $id = $request->get('booking_data_id');

        $booking_data = BookingData::find($id);
        $booking = $booking_data->booking;
        $email = $booking_data->contact->email;
        $html = '';
        $address = $booking->address;
        $b_date = date("d-m-Y h:i A", strtotime($booking_data->date));
        if ($request->get('confirm') == 1) {
            $b_date = date("d-m-Y h:i A", strtotime($booking_data->new_date[$request->get('alternate_date')]));
            $date = date("Y-m-d H:i:s", strtotime($b_date));
            $html = '';
            $html .= "<p>Boxit Foundations has accepted the requested timing for the following booking:</p>";
            $html .= "<p>Address : <strong><u>$address</u></strong></p>";
            $html .= "<p>Date : <strong><u>$b_date</u></strong></p>";
            $html .= '<br><p style="display:none">Project ID #' . $booking_data->booking_id . '</p>Thank You,<br>
                Jules<br><br>
                <img src="https://boxit.staging.app/img/logo2581-1.png" style="width:75px;height:30px" class="mail-logo" alt="Boxit Logo">

                ';
            $details['to'] = $email;;
            $details['subject'] = 'Booking Revised';
            $details['body'] = $html;
            dispatch(new BookingEmailJob($details));
            BookingData::where('id', $id)
                ->update(array('status' => 1, 'date' => date("Y-m-d H:i:s", strtotime($date))));
        }

        if ($request->get('confirm') == 0) {

            BookingData::where('id', $id)
                ->update(array('status' => 0, 'date' => date("Y-m-d H:i:s", strtotime($request->get('date')))));
            $b_date = date("d-m-Y h:i A", strtotime($booking_data->date));
            $html .= "<p>Boxit Foundations has suggested the below alternate time(s)</p>";
            $html .= "<p>Address : <strong><u>$address</u></strong></p>";
            $html .= "<p>Revised Date : <strong><u>$b_date</u></strong></p>";
            $enc_key = base64_encode($booking_data->id);
            $url = URL("reply/$enc_key");
            $html .= "<a href='" . $url . "' style='border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
	user-select: none;
	text-decoration: none !important;
    line-height: 1.5;
    border-radius: 0.25rem;color:#fff;background-color: #172b4d;border-color: #172b4d;'>Click here to approve or make a change request</a><br>";
            $html .= '<br><p style="display:none">Project ID #' . $booking_data->booking_id . '</p>Thank You,<br>
    Jules<br><br>
    <img src="https://boxit.staging.app/img/logo2581-1.png" style="width:75px;height:30px" class="mail-logo" alt="Boxit Logo">

    ';
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
                    $leaves = Leave::whereDate('date', '=', $booking_date)->get();
                    foreach ($leaves as $leave) {
                        $inner_html .= "<span class='red_bullet monthly_booking annual_leave' data-note='" . $leave->note . "'>" . $leave->title . " - " . date("h:i A", strtotime($leave->date)) . "</span>";
                    }
                    foreach ($booking_datas as $booking_data) {
                        if (!empty($booking_data->booking)) {
                            $address = implode(' ', array_slice(explode(' ', $booking_data->booking->address), 0, 3));
                            $dep = $booking_data->department->title . ($booking_data->service != '' ? ' (' . $booking_data->service . ')' : '');
                            $style = '';
                            switch ($booking_data->status) {
                                case '0':
                                    $class = "orange_bullet monthly_booking";
                                    $style = 'background: ' . $booking_data->booking->pending_background_color . ';color:' . $booking_data->booking->pending_text_color;
                                    break;
                                case '1':
                                    $class = "green_bullet monthly_booking";
                                    $style = 'background: ' . $booking_data->booking->confirm_background_color . ';color:' . $booking_data->booking->confirm_text_color;
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

    public function daily_calender(Request $request)
    {
        $date = $request->get('today_date');
        $booking_date = date('Y-m-d', strtotime($date));
        $foreman_id = $request->get('foreman_id');
        $department_id = array(2, 3, 4, 5, 6, 7, 8, 9, 10);
        $data = "";
        foreach ($department_id as $id) {
            $booking_data = BookingData::where(array('department_id' => $id))->whereHas('booking', function ($query) use ($foreman_id) {
                if (!empty($foreman_id))
                    $query->where('foreman_id', $foreman_id);
            })->whereDate('date', '=', $booking_date)
                ->get();
            $b_id = '';
            foreach ($booking_data as $boo) {
                $address = implode(' ', array_slice(explode(' ', $boo->booking->address), 0, 5));
                $dep = $boo->department->title . ($boo->service != '' ? ' (' . $boo->service . ')' : '');
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
                $data .= "<span class='$class' style='$style' data-id='" . $b_id . "'>$dep:$address</span>";
            }
        }
        if (empty($data)) {
            $data .= '<span>No scheduled bookings today</span>';
        }
        return response()->json($data);
    }

    public function mobile_calender(Request $request)
    {
        $dates = $request->get('dates');
        $year = $request->get('year');
        $foreman_id = $request->get('foreman_id');
        $requested_month = $request->get('month') + 1;
        $data = [];
        foreach ($dates as $date) {
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
                foreach ($booking_data as $boo) {
                    $address = implode(' ', array_slice(explode(' ', $boo->booking->address), 0, 3));
                    $dep = $boo->department->title . ($boo->service != '' ? ' (' . $boo->service . ')' : '');
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
                    $data[$date['day']][] = "<span class='$class' style='$style' data-id='" . $b_id . "'>$dep:$address</span>";
                }
            }
            if (!isset($data[$date['day']]))
                $data[$date['day']] = [];
        }
        return response()->json($data);
    }

    public function calender(Request $request)
    {
        $dates = $request->get('dates');
        $year = $request->get('year');
        $foreman_id = $request->get('foreman_id');
        if (!empty($foreman_id))
            $name = User::find($foreman_id)->name;
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
                
                    $staff_leaves = StaffLeave::whereDate('from_date', '<=', $booking_date)->whereDate('to_date', '>=', $booking_date)->get();
                    foreach ($staff_leaves as $leave) {
                        $html .= "<span class='red_box staff-leaves' style='display:none'>" . ucfirst($leave->user?->name) . " - On Leave</span>";
                    }
            
                $leaves = Leave::whereDate('date', '=', $booking_date)->get();
                foreach ($leaves as $leave) {
                    $html .= "<span class='red_box annual_leave' data-note='" . $leave->note . "' >" . $leave->title . " - " . date("h:i A", strtotime($leave->date)) . "</span>";
                }
                foreach ($booking_data as $boo) {
                    if (MobileDetect::isTablet()) {
                        $address = substr($boo->booking->address, 0, 9);
                    } else {
                        $address = strlen($boo->booking->address) > 24 ? substr($boo->booking->address, 0, 24) . "..." : $boo->booking->address;
                    }
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
        $booking_data = $booking->BookingData->sortBy('department_id');
        $html = '<div class="row">
								<div class="col-md-6" style="border-right: 1px solid #E7E7E7;">
									<div class="pods confirmed-txt pop-flex">
										<p>Foreman</p>
										<span>' . ucfirst($booking->foreman?->name) . '</span>
									</div>';
        foreach ($booking_data->slice(1, (int)count($booking_data) / 2) as $res) {
            $booking_date = $res->date;
            $title = $res->department->title . ($res->service != '' ? ' (' . $res->service . ')' : '') . ($res->reorder_no != '0' ? ' (Reorder' . $res->reorder_no . ')' : '');
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
        foreach ($booking_data->slice(((int)count($booking_data) / 2) + 1) as $res) {
            $title = $res->department->title . ($res->service != '' ? ' (' . $res->service . ')' : '') . ($res->reorder_no != '0' ? ' (Reorder' . $res->reorder_no . ')' : '');
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

        return array('id' => $booking->id, 'address' => $booking->address, 'bcn' => $booking->bcn, 'floor_type' => $booking->floor_type, 'floor_area' => $booking->floor_area, 'building_company' => $booking_data[0]->department_id == '1' ? $booking_data[0]->contact->title : 'NA', 'notes' => $booking->notes != '' ? $booking->notes : 'NA', 'html' => $html);
    }

    public function save_draft(Request $request)
    {
        $files = [];
        if (!empty($request->get('draft_id'))) {
            $delete_id = $request->get('draft_id');
            $this->delete_draft($delete_id);
        }
        if (!empty($request->get('existing_file'))) {
            $files = $request->get('existing_file');
        }
        $admin_email = \config('const.admin1');
        if ($admin_email != auth()->user()->email) {
            $email_body = "Hi,<br><b>" . $request->get('address') . "</b> has been saved as Draft by " . auth()->user()->name . ".";
            $email_body .= '<br>Thank You,<br><img src="https://boxit.staging.app/img/logo2581-1.png" style="width:75px;height:30px" class="mail-logo" alt="Boxit Logo">';
            dispatch(new BookingEmailJob(['to' => $admin_email, 'address' => $request->get('address'), 'subject' => 'Draft Saved', 'body' => $email_body]));
        }
        $draft = new Draft;
        $draft->address = $request->get('address');
        $draft->floor_area = $request->get('floor_area');
        $draft->floor_type = $request->get('floor_type');
        $draft->bcn = $request->get('bcn');
        $draft->notes = $request->get('notes');
        $draft->foreman_id = $request->get('foreman');
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
        $request_status = $request->get('status');

        foreach ($request->get('department') as $key => $val) {

            if ($key != 7) {
                $book_array = array(
                    'department_id' => $key,
                    'contact_id'  => $val,
                    'date' => @$requested_date[$key],
                    'draft_id' => $draft_id
                );
                if (empty($request_status[$key])) {
                    $book_array['status'] = 2;
                }
                DraftData::create($book_array);
            } else {
                if (is_array($val)) {
                    foreach ($val as $serk => $serv) {
                        $book_array = array(
                            'department_id' => $key,
                            'contact_id'  => $serv,
                            'date' => @$requested_date[$key][$serk],
                            'service' => $serk,
                            'draft_id' => $draft_id
                        );
                        DraftData::create($book_array);
                    }
                } else {
                    $book_array = array(
                        'department_id' => $key,
                        'contact_id'  => $val,
                        'date' => @$requested_date[$key],
                        'draft_id' => $draft_id
                    );
                    DraftData::create($book_array);
                }
            }
        }
        Session::flash('succes_msg', 'Draft has been saved successfuly.');

        return $draft_id;
    }

    public function draft($id)
    {
        $draft = Draft::find($id);
        $draft->DraftData = $draft->DraftData->groupBy('department_id', 'contact_id');
        $council_data = $draft->DraftData[7]->toArray();
        $draft->DraftData[7] = collect();
        foreach ($council_data as $res) {
            $array[$res['service']] = $res['date'];
            $draft->DraftData[7][$res['contact_id']] = $array;
            $draft->DraftData[7]['status'] = $res['status'];
        }

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
            $update_array = ['date' => date("Y-m-d H:i:s", strtotime($date)), 'status' => 1];
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
            $html = 'Hi,<br><br>';
            $html .= 'Unfortunately we need to move your booking for - ' . $booking->address . '<br>';
            $old_date = date("d-m-Y", strtotime($booking_data->date));
            $old_time = date("h:i:s A", strtotime($booking_data->date));
            if ($booking_data->department_id == '6' || $booking_data->department_id == '7' || $booking_data->department_id == '5')
                $html .= "BCN-" . ($booking->bcn != '' ? $booking->bcn : ' NA') . "<br>";
            $html .= "<p>FROM<br>Date - $old_date<br>Time- $old_time</p>";
            $new_date = date("d-m-Y", strtotime($date));
            $new_time = date("h:i:s A", strtotime($date));
            $html .= "<p>TO<br>Date - $new_date<br>Time- $new_time</p>";
            $html .= '<p>' . $reply_link . '</p>';

            $html .= '<p style="display:none">Project ID #' . $booking_data->booking_id . '</p>Thank You,<br>
                Jules<br><br>
                <img src="https://boxit.staging.app/img/logo2581-1.png" style="width:75px;height:30px" class="mail-logo" alt="Boxit Logo">

                ';

            $update_array = ['date' => date("Y-m-d H:i:s", strtotime($date))];
            $update_array['status'] = 0;

            $details['to'] = $contact->email;
            $details['name'] = $contact->title;
            $details['url'] = 'testing';
            $details['subject'] = 'Booking Revised';
            $details['body'] = $html;
            dispatch(new BookingEmailJob($details));
        }

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
        $notification->notification = '<b>' . ucfirst(Auth::user()->name) . '</b> has put <b>' . $booking->department->title . ($booking->service != '' ? ' (' . $booking->service . ')' : '') . '</b> for <b>' . $booking->booking->address . '</b> on hold';
        $notification->booking_id = $booking->booking_id;
        $notification->save();

        Session::flash('succes_msg', 'Department status successfully changed to On Hold.');
    }

    public function new_booking_email($id)
    {
        $obj = base64_decode(($id));
        $data = json_decode($obj, true);
        $update_array = ['status' => 0];
        if (isset($data['date'])) {
            $date = $data['date'];
            $update_array['date'] = date('Y-m-d H:i:s', strtotime($date));
        }
        if (isset($data['contact_id'])) {
            $update_array['contact_id'] = $data['contact_id'];
        }
        $id = $data['id'];
        BookingData::where('id', $id)->update($update_array);
        $booking_data = BookingData::find($id);
        $booking = $booking_data->booking;
        $mail = MailTemplate::where(array('status' => 1, 'department_id' => $booking_data->department_id))->get();
        return view('new_booking_mail', compact('booking_data', 'booking', 'mail', 'id'));
    }

    public function reorder(Request $request)
    {
        $id = $request->get('id');
        $date = $request->get('date');
        $booking_data = BookingData::find($id);
        $book_array = array(
            'department_id' => $booking_data->department_id,
            'contact_id'  => $booking_data->contact_id,
            'date' => $date,
            'service' => $booking_data->service,
            'booking_id' => $booking_data->booking_id,
            'reorder_no' => $booking_data->reorder_no + 1
        );
        $new = BookingData::create($book_array);
        return $new['id'];
    }

    public function change_time()
    {
        $booking_datas = BookingData::all();
        foreach ($booking_datas as $res) {
            $res->date = date('Y-m-d H:i:s', strtotime($res->date));
            $res->save();
        }
    }

    public function store_foreman_notes(Request $request)
    {
        $id = $request->get('id');
        $date = date('Y-m-d 00:00:00', strtotime($request->get('date')));
        $notes = $request->get('notes');
        $matchThese = ['foreman_id' => $id, 'date' => $date];
        foremanNote::updateOrCreate($matchThese, ['notes' => $notes, 'given_by' => Auth::id()]);
        return true;
    }

   
}
