<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingData;
use App\Models\ProjectStatusLabel;
use App\Models\QaChecklist;
use App\Models\MailTemplate;
use App\Models\Contact;
use App\Models\User;
use App\Jobs\BookingEmailJob;
use DB;
use Session;

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
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
        }

        $projects = new Booking;

        if (!empty(request('year')) || (!empty(request('month')))) {
            $projects =  $projects->whereHas('BookingData', function ($query) {
                if (!empty(request('year')))
                    $query->whereYear('created_at', '=', request('year'));
                if (!empty(request('month')))
                    $query->whereMonth('created_at', '=', request('month'));
            });
        }
        if (!empty(request('completed_projects'))) {
            $projects = $projects->whereHas('PassedProjectStatus', function ($query) {
                $query->select(DB::raw('count(*)'))->havingRaw('COUNT(*) = ' . DB::RAW("(SELECT COUNT(*)  FROM `project_status_label` WHERE `department_id` = '' OR `department_id` IN (SELECT department_id  FROM `booking_data` WHERE `booking_id` = `bookings`.`id`))"));
            });
        }else
        {
            $projects = $projects->whereDoesntHave('PassedProjectStatus', function ($query) {
                $query->select(DB::raw('count(*)'))->havingRaw('COUNT(*) = ' . DB::RAW("(SELECT COUNT(*)  FROM `project_status_label` WHERE `department_id` = '' OR `department_id` IN (SELECT department_id  FROM `booking_data` WHERE `booking_id` = `bookings`.`id`))"));
            });   
        }

        if (!empty(request('q')))
        $projects = $projects->where('address', 'like', '%' . request('q') . '%');
        $projects = $projects->get();
        return view('project', compact('projects', 'months'))->render();
    }

    public function change_project_foreman(Request $request)
    {
        $booking_id = $request->get('project_id');
        $foreman_id = $request->get('foreman_id');
        Booking::where('id', $booking_id)
            ->update([
                'foreman_id' => $foreman_id
            ]);
        return true;
    }

    public function update_project(Request $request)
    {
        if ($request->get('field') == 'building_company') {
            BookingData::where('id', $request->get('id'))->update(['contact_id' => $request->get('val')]);
        } else {
            Booking::where('id', $request->get('id'))->update([$request->get('field') => $request->get('val')]);
        }
        Session::flash('succes_msg', 'Project has been updated successfuly.');
    }

    public function delete_file(Request $request)
    {
        $booking = Booking::find($request->get('id'));
        $booking->file = array_diff($booking->file, array($request->get('file')));
        $booking->save();
        $file_path = public_path() . '/images/' . $request->get('file');
        unlink($file_path);
        Session::flash('succes_msg', 'File has been deleted successfuly.');
    }

    public function save_note(Request $request)
    {
        $booking_data = BookingData::find($request->get('id'));
        $booking_data->notes = $request->get('note');
        $booking_data->save();
        return true;
    }

    public function save_image(Request $request)
    {
        $booking = Booking::find($request->get('id'));
        $files = [];
        if (!empty($booking->file)) {
            $files = $booking->file;
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
        Session::flash('succes_msg', 'File has been uploaded successfuly.');
    }

    public function renderproject(Request $request)
    {
        $project = Booking::find($request->get('id'));
        $foremans = User::whereHas("roles", function ($q) {
            $q->where("name", "Foreman");
        })->get();
        $department_ids = BookingData::where('booking_id', $request->get('id'))->pluck('department_id');
        $markout_checklist = $project->MarkoutChecklist;
        $safety = $project->SafetyPlan;
        //dd($safety);
        $qaChecklist = QaChecklist::all();
        $ProjectStatusLabel = ProjectStatusLabel::where(function ($query) use ($department_ids) {
            $query->where('department_id', '=', '')
                ->orWhereIn('department_id', $department_ids);
        })
            ->get();
        $contacts = Contact::all();
        return view('single-project', compact('contacts', 'foremans', 'safety', 'project', 'qaChecklist', 'markout_checklist', 'ProjectStatusLabel'))->render();
    }
    public function delete(Request $request)
    {
        $project_id = $request->get('id');
        $booking = Booking::find($project_id);
        $active_templates = MailTemplate::where('status', 1)->pluck('department_id')->toArray();
        $booking_datas = BookingData::whereIn('department_id', $active_templates)->where(array('booking_id' => $project_id))->get();
        Booking::find($project_id)->delete();
        foreach ($booking_datas as $booking_data) {
            $b_date =   date("d-m-Y h:i A", strtotime($booking_data->date));
            $html = '<p>The following booking has been cancelled.</p>';
            $html .= "<p>Address: " . $booking->address . "<br>";
            $html .= "Date: " . $b_date . "</p>";
            $html .= 'Thank You,<br>
                Jules<br><br>
                <img src="https://boxit.staging.app/img/logo2581-1.png" style="width:75px;height:30px" class="mail-logo" alt="Boxit Logo">

                ';
            $contact = Contact::find($booking_data->contact_id);
            $details['to'] = $contact->email;
            $details['name'] = $contact->title;
            $details['url'] = 'testing';
            $details['subject'] = 'Booking Cancelled';
            $details['body'] = $html;
            //dispatch(new BookingEmailJob($details));
            BookingData::find($booking_data->id)->delete();
        }

        echo true;
    }
}
