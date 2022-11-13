<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingData;
use App\Models\ProjectStatusLabel;
use App\Models\MailTemplate;
use App\Models\Contact;
use App\Jobs\BookingEmailJob;

class ProjectController extends Controller
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
        $projects = Booking::all();
        return view('project', compact('projects'))->render();
    }

    public function renderproject(Request $request)
    {
        $project = Booking::find($request->get('id'));
        $ProjectStatusLabel = ProjectStatusLabel::all();
        return view('single-project', compact('project', 'ProjectStatusLabel'))->render();
    }
    public function delete(Request $request)
    {
        $project_id = $request->get('id');
        $booking= Booking::find($project_id);
        $active_templates = MailTemplate::where('status', 1)->pluck('department_id')->toArray();
        $booking_datas = BookingData::whereIn('department_id', $active_templates)->where(array('booking_id' => $project_id))->get();
         foreach($booking_datas as $booking_data)
        {
         $b_date=   date("d-m-Y h:i",strtotime($booking_data->date));
        $html='<p>The following booking has been cancelled.</p>';
        $html.="<p>Address: ".$booking->address."<br>";
        $html.="Date: ".$b_date."</p>";
        $html.='Thanks,<br>
      Jules,<br>
      BOXIT Sales<br>
      <a href="mailto:admin@boxitfoundations.co.nz">admin@boxitfoundations.co.nz</a>
      <br>
      <a href="https://boxitfoundations.co.nz">https://boxitfoundations.co.nz</a><br>';
        $contact = Contact::find($booking_data->contact_id);
        $details['to'] = $contact->email;
        $details['name'] = $contact->title;
        $details['url'] = 'testing';
        $details['subject'] = 'Booking Cancelled';
        $details['body'] = $html;
        dispatch(new BookingEmailJob($details));
        }
        Booking::find($project_id)->delete();

        echo true;
    }
}
