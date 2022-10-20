<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingData;
use App\Jobs\BookingEmailJob;
use App\Models\MailTemplate;
use App\Models\Contact;

class BookingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
        if ($files = $request->file('file_upload')) {
            $name = $files->getClientOriginalName();
            $files->move('images', $name);
            $booking->file = $name;
        }
        $booking->save();

        $booking_id = $booking->id;
        $requested_date = $request->get('date');
        foreach ($request->get('department') as $key => $val) {

            BookingData::create(array(
                'department_id' => $key,
                'contact_id'  => $val,
                'date' => @$requested_date[$key],
                'booking_id' => $booking_id
            ));
        }
        return redirect()->to('booking/' . $booking_id)->with('succes_msg', 'Your booking has been saved.Please check mail templates');
    }

    public function booking($id)
    {
        $booking = Booking::find($id);
        $mail = MailTemplate::where(array('status' => 1))->get();
        return view('update_mail', compact('booking', 'mail'));
    }

    public function send_mail(Request $request)
    {
        $mail_data = $request->get('mail_data');
        foreach ($mail_data as $res) {
            $booking_data = BookingData::find($res['booking_id']);
            $booking_id = $booking_data->booking_id;
            $contact = Contact::find($booking_data->contact_id);
            $details['to'] = $contact->email;
            $details['name'] = $contact->title;
            $details['url'] = 'testing';
            $details['subject'] = $res['subject'];
            $details['body'] = $res['body'];
            dispatch(new BookingEmailJob($details));
        }
        Booking::where('id', $booking_id)
            ->update([
                'mail_sent' => 1
            ]);

        return array("success" => true);
    }

    public function reply($id)
    {
        $booking_data_id = base64_decode($id);
        $booking_data = BookingData::find($booking_data_id);
        if ($booking_data->status != '0') {
            return 'Link has been used...';
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
            $booking_data=BookingData::find($id);
            $booking=$booking_data->booking;
            $contact=$booking_data->contact;
            $department=$booking_data->department;
            $update_data['status']=$request->get('confirm');
            if($request->get('confirm')==2)
            {   
                $html='';
                $address=$booking->address;
                $html.="<p>The following booking has been cancelled.</p>";
                $html.="<p>Address : <strong><u>$address</u></strong></p>";
                $html.="<p>Department : <strong><u>$department->title</u></strong></p>";
                $html.="<p>Contact : <strong><u>$contact->title</u></strong></p>";
                $html.="<p>Date : <strong><u>$booking_data->date</u></strong></p>";
                $html.="<br><p>Contact has suggested below alternate time</p>";
                if(!empty($request->get('date1')))
                {
                    $html.="<p>Alternate DateTime 1 : ".$request->get('date1')."</p>";
                    $update_data['new_date'][]=$request->get('date1');
                }
                if(!empty($request->get('date2')))
                {
                    $html.="<p>Alternate DateTime 2 : ".$request->get('date2')."</p>";
                    $update_data['new_date'][]=$request->get('date2');
                }
                if(!empty($request->get('date3')))
                {
                    $html.="<p>Alternate DateTime 3 : ".$request->get('date3')."</p>";
                    $update_data['new_date'][]=$request->get('date3');
                }
                $enc_key=base64_encode($booking_data->id);
                $url=URL("admin-reply/$enc_key");
                $html.="<a href='".$url."' style='border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
	user-select: none;
	text-decoration: none !important;
    line-height: 1.5;
    border-radius: 0.25rem;color:#fff;background-color: #172b4d;border-color: #172b4d;'>CLICK HERE FOR ALTERNATE SCHEDULE </a>";
                $details['to'] = env('ADMIN_EMAIL');
                $details['subject'] = 'Booking Cancelled';
                $details['body'] = $html;
                dispatch(new BookingEmailJob($details));
            }
            BookingData::where('id', $id)
            ->update($update_data);

    }
    public function admin_reply_confirmation(Request $request)
    {
        
        if($request->get('confirm')==1)
        {
            $id = $request->get('booking_data_id');
            $booking_data=BookingData::find($id);
            BookingData::where('id', $id)
            ->update(array('status'=>1,'date'=>$booking_data->new_date[$request->get('alternate_date')]));
        }

        if($request->get('confirm')==0)
        {
            
          $id = $request->get('booking_data_id');
          BookingData::where('id', $id)
          ->update(array('status'=>0,'date'=>$request->get('date')));
            $booking_data=BookingData::find($id);
            $booking=$booking_data->booking;
            $email=$booking_data->contact->email;
                $html='';
                $address=$booking->address;
                $html.="<p>Boixt has requested revised time for following booking.</p>";
                $html.="<p>Address : <strong><u>$address</u></strong></p>";
                $html.="<p>Floor Area : <strong><u>$booking->floor_area</u></strong></p>";
                $html.="<p>Floor Type : <strong><u>$booking->floor_type</u></strong></p>";
                $html.="<p>Revised Date : <strong><u>$booking_data->date</u></strong></p>";
                $enc_key=base64_encode($booking_data->id);
                $url=URL("reply/$enc_key");
                $html.="<a href='".$url."' style='border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
	user-select: none;
	text-decoration: none !important;
    line-height: 1.5;
    border-radius: 0.25rem;color:#fff;background-color: #172b4d;border-color: #172b4d;'>CLICK HERE TO CONFIRM OR DENY BOOKING</a>";
                $details['to'] = $email;;
                $details['subject'] = 'Booking Revised';
                $details['body'] = $html;
                dispatch(new BookingEmailJob($details));
            
        }
        

    }
    public function calender(Request $request)
    {
        $dates = $request->get('dates');
        $year = $request->get('year');
        $month = $request->get('month') + 1;
        $html = '';
        foreach ($dates as $date) {
            $html .= '<div class="foo pd-boxes">';
            if ($date['thisMonth'] != 1) {
                if ($date['day'] >= 25)
                    $month = $month - 1;
                else
                    $month = $month + 1;
            }
            $booking_date = date('Y-m-d', strtotime("$year-$month-" . $date['day']));
            $foremans = User::whereHas("roles", function ($q) {
                $q->where("name", "Foreman");
            })->get();
            foreach ($foremans as $res) {
                $booking_data = Booking::where(array('foreman_id' => $res->id))->whereDate('created_at', '=', date('Y-m-d', strtotime($booking_date)))->first();
                if (!empty($booking_data)) {
                    $html .= "<div class='booked_div green_box show_booking' data-id='" . $booking_data->id . "'>" . $booking_data->address . "</div>";
                } else {
                    $html .= "<div class='booked_div'></div>";
                }
            }
            $department_id = array(2, 3, 4, 5, 6, 7, 8, 9, 10);
            foreach ($department_id as $id) {
                $booking_data = BookingData::where(array('department_id' => $id, 'date' => $booking_date))->first();
                $b_id = '';
                if (!empty($booking_data)) {
                    $address = $booking_data->booking->address;
                    switch ($booking_data->status) {
                        case '0':
                            $class = "orange_box show_booking";
                            break;
                        case '1':
                            $class = "green_box show_booking";
                            break;
                        case '2':
                            $class = "red_box show_booking";
                            break;
                        default:
                            $class = "show_booking";
                    }
                    $b_id = $booking_data->booking_id;
                } else {
                    $address = "";
                    $class = "";
                }
                $html .= "<div class='booked_div $class ' data-id='" . $b_id . "'>$address</div>";
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
										<p>Foreman-' . $booking->foreman->name . '</p>
										<span>Confirmed</span>
									</div>';
         foreach($booking_data->slice(1,4) as $res)
         {
            $title=$res->department->title;
            switch ($res->status) {
                case '0':
                    $class = "pending-txt";
                    $status="Pending";
                    break;
                case '1':
                    $class = "confirmed-txt";
                    $status="Confirmed";
                    break;
                case '2':
                    $class = "cancelled-txt";
                    $status="Cancelled";
                    break;
                default:
                    $class = "";
                    $status="";

            }
        
        $html .='<div class="steel  pop-flex '.$class.'">
										<p>'.$title.'</p>
										<span>'.$status.'</span>
									</div>
									';
         }
         $html .=		'</div><div class="col-md-6">';
         foreach($booking_data->slice(5) as $res)
         {
            $title=$res->department->title;
            switch ($res->status) {
                case '0':
                    $class = "pending-txt";
                    $status="Pending";
                    break;
                case '1':
                    $class = "confirmed-txt";
                    $status="Confirmed";
                    break;
                case '2':
                    $class = "cancelled-txt";
                    $status="Cancelled";

                    break;
                default:
                    $class = "";
                    $status="";

            }
						$html.='			<div class="pods '.$class.' pop-flex">
										<p>'.$title.'</p>
										<span>'.$status.'</span>
									</div>';}
									
							$html.='</div></div>';
							
        return array('address' => $booking->address, 'notes' => $booking->notes, 'html' => $html);
    }
}
