<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingData;
use App\Models\ProjectStatusLabel;
use App\Models\QaChecklist;
use App\Models\MailTemplate;
use App\Models\Contact;
use App\Models\ProjectCheckboxStatus;
use App\Models\User;
use App\Models\FormPerDate;
use App\Models\Department;
use App\Models\Image;
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
        DB::enableQueryLog();
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
        }

        $projects = new Booking;

        if (!empty(request('year')) || (!empty(request('month')))) {
            $projects = $projects->whereHas('BookingData', function ($query) {
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
        } else {
            $projects = $projects->whereDoesntHave('PassedProjectStatus', function ($query) {
                $query->select(DB::raw('count(*)'))->havingRaw('COUNT(*) = ' . DB::RAW("(SELECT COUNT(*)  FROM `project_status_label` WHERE `department_id` = '' OR `department_id` IN (SELECT department_id  FROM `booking_data` WHERE `booking_id` = `bookings`.`id`))"));
            });
        }

        if (!empty(request('passed_with_cond'))) {
            $projects = $projects->whereHas('PassedWithCond', function ($query) {

            });
        } else {
            $projects = $projects->whereDoesntHave('PassedWithCond', function ($query) {

            });
        }

        if (!empty(request('q')))
            $projects = $projects->where(function ($query) {
                $query->where('address', 'like', '%' . request('q') . '%')
                    ->orWhere('bcn', 'like', '%' . request('q') . '%')->orWhereHas('BookingData.department', function ($query1) {
                        $query1->where('title', 'like', '%' . request('q') . '%');
                    });
                ;
            });

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
        $forms = FormPerDate::where(['project_id' => $project->id])->get();
        $departments = Department::with([
            "contacts" => function ($q) {
                $q->orderBy('title', 'ASC');
            }
        ])->get();
        $foremans = User::whereHas("roles", function ($q) {
            $q->where("name", "Foreman");
        })->get();
        $department_ids = BookingData::where('booking_id', $request->get('id'))->pluck('department_id');
        $markout_checklist = $project->MarkoutChecklist;
        //dd($safety);
        $checked_checkbox_data = ProjectCheckboxStatus::where('project_id', $request->get('id'))->first();
        if (!empty($checked_checkbox_data->status)) {
            $checked_checkbox_status = $checked_checkbox_data->status;
        } else {
            $checked_checkbox_status = [];
        }
        $ProjectStatusLabel = ProjectStatusLabel::where(function ($query) use ($department_ids) {
            $query->where('department_id', '=', '')
                ->orWhereIn('department_id', $department_ids);
        })
            ->get();
        $contacts = Contact::orderBy('title')->get();
        return view('single-project', compact('forms', 'department_ids', 'departments', 'checked_checkbox_status', 'contacts', 'foremans', 'project', 'markout_checklist', 'ProjectStatusLabel'))->render();
    }
    public function delete(Request $request)
    {
        $project_id = $request->get('id');
        $booking = Booking::find($project_id);
        $active_templates = MailTemplate::where('status', 1)->pluck('department_id')->toArray();
        $booking_datas = BookingData::whereIn('department_id', $active_templates)->where(array('booking_id' => $project_id))->get();
        Booking::find($project_id)->delete();
        foreach ($booking_datas as $booking_data) {
            $b_date = date("d-m-Y h:i A", strtotime($booking_data->date));
            $html = '<p>The following booking has been cancelled.</p>';
            $html .= "<p>Address: " . $booking->address . "<br>";
            $html .= "Date: " . $b_date . "</p>";
            $html .= '<p style="display:none">Project ID #' . $booking_data->booking_id . '</p>Thank You,<br>
                Andy<br><br>
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

    public function change_checkbox_status(Request $request)
    {
        ProjectCheckboxStatus::updateOrCreate(['project_id' => $request->get('project_id')], ['status' => $request->get('status')]);
    }

    public function viewForm(Request $request)
    {
        $form = FormPerDate::find($request->get('id'));
        $project = Booking::find($form->project_id);
        $safety = $form->SafetyPlan;
        $incident_data = $form->incident;
        $qaChecklist = QaChecklist::all();
        $foreman_images = Image::query();
        if ($form->form_type == 1) {
            return view('forms.view-onsite', compact('form', 'foreman_images', 'project', 'qaChecklist'))->render();
        } elseif ($form->form_type == 2) {
            return view('forms.view-safety', compact('form', 'foreman_images', 'project', 'safety'))->render();
        } elseif ($form->form_type == 3) {
            return view('forms.view-accident', compact('form', 'foreman_images', 'project', 'incident_data'))->render();

        }

    }

    public function deleteForm(Request $request)
    {
        $id = $request->get('id');
        $form = FormPerDate::find($id);
        $form->qasign()->delete();
        $form->incident()->delete();
        $form->SafetyPlan()->delete();
        $form->images()->delete();
        $form->delete();
        return true;
    }

    public function addBookingData(Request $request)
    {
        //dd($request->all());
        $id = $request->get('project_id');
        $booking = Booking::find($id);
        $requested_date = $request->get('date');
        $department_ids = [];
        foreach ($request->get('department') as $key => $val) {
            $department_ids[] = $key;
            if ($key != 7) {
                $book_array = array(
                    'department_id' => $key,
                    'contact_id' => $val,
                    'date' => @$requested_date[$key],
                    'booking_id' => $id
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
                            'contact_id' => $serv,
                            'date' => @$requested_date[$key][$serk],
                            'service' => $serk,
                            'booking_id' => $id
                        );
                        BookingData::create($book_array);
                    }
                } else {
                    $book_array = array(
                        'department_id' => $key,
                        'contact_id' => $val,
                        'date' => @$requested_date[$key],
                        'booking_id' => $id
                    );
                    BookingData::create($book_array);
                }
            }
        }
        $booking->update([
            'mail_sent' => 0
        ]);
        $booking = Booking::find($id);
        $booking_data = $booking->booking_data;
        $mail = MailTemplate::where(array('status' => 1))->whereIn('department_id', $department_ids)->get();
        return view('update_mail', compact('booking_data', 'booking', 'mail', 'id'));
    }

    public function delete_department(Request $request)
    {
        $id = $request->get('deleted_department_id');
        $booking_data = BookingData::find($id);
        $booking_data->notes = $request->get('note');
        $booking_data->status = 2;
        $booking_data->save();
        $project_id = $booking_data->booking_id;
        $booking_data->delete();
        return redirect("/projects?project_id=" . $project_id);
    }

    public function change_council(Request $request)
    {
        $id = $request->get('project_id');
        $booking = Booking::find($id);
        $requested_date = $request->get('date');
        $booking_data_ids = [];
        foreach ($request->get('department') as $key => $val) {

            if (is_array($val)) {
                $existing_data=$booking->CouncilData;
                if($existing_data[0]->contact_id!=array_values($val)[0])            
                {
                    $deleted=1;
                    BookingData::where([['booking_id',$id],['department_id',7]])->delete();
                }
                foreach ($val as $serk => $serv) {
                    $book_array = array(
                        'department_id' => $key,
                        'contact_id' => $serv,
                        'date' => @$requested_date[$key][$serk],
                        'service' => $serk,
                        'booking_id' => $id
                    );
                    $booking_datas[]=BookingData::create($book_array);
                }
            } else {
                BookingData::where([['booking_id',$id],['department_id',7]])->delete();
                $book_array = array(
                    'department_id' => $key,
                    'contact_id' => $val,
                    'date' => @$requested_date[$key],
                    'booking_id' => $id
                );
                $booking_datas[]=BookingData::create($book_array);
            }
        }

        $booking->update([
            'mail_sent' => 0
        ]);
        $booking = Booking::find($id);
        $council_data =  $booking_datas;
        $mail = MailTemplate::where(array('status' => 1))->where('department_id',7)->get();
        return view('council_mail', compact('council_data', 'booking', 'mail', 'id'));
    }
}
