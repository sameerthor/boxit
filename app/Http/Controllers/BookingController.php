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
        return redirect()->to('booking/{booking_id}')->with('succes_msg', 'Your booking has been saved.Please check mail templates');
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
         $booking_data=BookingData::find($res['booking_id']);
         $booking_id=$booking_data->booking_id;
         $contact=Contact::find($booking_data->contact_id);
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

        return array("success"=>true);
    }

    public function reply($id)
    {
      $booking_data_id= base64_decode($id);
        $booking_data=BookingData::find($booking_data_id);
        if($booking_data->status != '0')
        {
           return 'Link has been used...';
        }
      return view('email_reply', compact('booking_data'));

    }

    public function reply_confirmation(Request $request)
    {
      $id=$request->get('booking_data_id');
     BookingData::where('id', $id)
     ->update(array('status'=>$request->get('confirm')));
    }
    
    
}
