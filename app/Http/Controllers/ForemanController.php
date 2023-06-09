<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingData;
use App\Models\QaChecklist;
use App\Models\MarkoutChecklist;
use App\Models\ProjectQaChecklist;
use App\Models\ProjectStatusLabel;
use App\Models\ProjectStatus;
use App\Jobs\BookingEmailJob;
use App\Models\ForemanTemplates;
use App\Models\ProjectCheckboxStatus;
use App\Models\StartupChecklist;
use App\Models\Boxing;
use App\Models\Leave;
use App\Models\Incident;
use App\Models\Image;
use App\Models\StaffLeave;
use App\Models\foremanNote;
use App\Models\SafetyPlan;
use App\Models\Stripping;
use App\Models\QaSign;
use Carbon\Carbon;
use App\Models\PodsSteel;
use App\Models\PodsSteelValue;
use Auth;
use DB;
use Twilio\Rest\Client;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class ForemanController extends Controller
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
        $foreman = User::find(Auth::id());
        return view('formancalender', compact('departments', 'foreman'));
    }

    public  function daysInMonth($iMonth, $iYear)
    {
        return cal_days_in_month(CAL_GREGORIAN, $iMonth, $iYear);
    }

    public function notes_dates(Request $request)
    {
        $dates = $request->get('dates');
        $year = $request->get('year');
        $month = $request->get('month') + 1;
        $data = [];
        foreach ($dates as $date) {
            $booking_date = date('Y-m-d', strtotime("$year-$month-" . $date['day']));
            $res = foremanNote::where(array('foreman_id' => Auth::id()))->whereDate('date', $booking_date)->get();
            if (count($res) > 0)
                $data[] = date('d F Y', strtotime($booking_date));
        }
        return $data;
    }

    public function calender(Request $request)
    {
        $dates = $request->get('dates');
        $year = $request->get('year');
        $requested_month = $request->get('month') + 1;
        $foreman_id=Auth::id();
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
            $booking_date = date('Y-m-d', strtotime("$year-$month-" . $date['day']));

            $department_id = array(2, 3, 4, 5, 6, 7, 8, 9, 10);
            foreach ($department_id as $id) {
                $booking_data = BookingData::whereHas('booking', function ($q) {
                    $q->where('foreman_id', Auth::id());
                    $q->orWhere('foreman_id', 19);

                })->where(array('department_id' => $id))->whereDate('date', '=', $booking_date)
                    ->get();
                $b_id = '';
                $html .= "<div class='booked_div'>";
                
                    $staff_leaves = StaffLeave::whereDate('date', '=', $booking_date)->where('staff_id',$foreman_id)->get();
                    foreach ($staff_leaves as $leave) {
                        $html .= "<span class='red_box' >On Leave</span>";
                    }
        
                $leaves = Leave::whereDate('date', '=', $booking_date)->get();
                foreach ($leaves as $leave) {
                    $html .= "<span class='red_box' >" . $leave->title . "</span>";
                }
                foreach ($booking_data as $boo) {
                    $address = strlen($boo->booking->address) > 24 ? substr($boo->booking->address, 0, 24) . "..." : $boo->booking->address;
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

    public function daily_calender(Request $request)
    {
        $date = $request->get('today_date');
        $booking_date = date('Y-m-d', strtotime($date));
        $foreman_id = Auth::id();
        $department_id = array(2, 3, 4, 5, 6, 7, 8, 9, 10);
        $data = "";
        foreach ($department_id as $id) {
            $booking_data = BookingData::where(array('department_id' => $id))->whereHas('booking', function ($query) use ($foreman_id) {
                $query->where('foreman_id', $foreman_id);
                $query->orWhere('foreman_id', 19);

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
        $foreman_id = Auth::id();
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
                    $query->where('foreman_id', $foreman_id);
                    $query->orWhere('foreman_id', 19);
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
                    $booking_datas = BookingData::whereHas('booking', function ($q) {
                        $q->where('foreman_id', Auth::id());
                        $q->orWhere('foreman_id', 19);
                    })->whereDate('date', '=', $booking_date)
                        ->get();
                    $leaves = Leave::whereDate('date', '=', $booking_date)->get();
                    foreach ($leaves as $leave) {
                        $inner_html .= "<span class='red_bullet monthly_booking' >" . $leave->title . "</span>";
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
            $title = $res->department->title . ($res->service != '' ? ' (' . $res->service . ')' : '');
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

            $html .= '<div class="steel  pop-flex ' . $class . '">
										<p>' . $title . '</p>
										<span>' . date('d/m/Y h:i A', strtotime($booking_date)) . ' - ' . $status . '</span>
									</div>
									';
        }
        $html .=        '</div><div class="col-md-6">';
        foreach ($booking_data->slice(5) as $res) {
            $title = $res->department->title . ($res->service != '' ? ' (' . $res->service . ')' : '');
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

        return array('id'=>$booking->id,'address' => $booking->address, 'bcn' => $booking->bcn, 'floor_type' => $booking->floor_type, 'floor_area' => $booking->floor_area, 'building_company' => $booking_data[0]->department_id == '1' ? $booking_data[0]->contact->title : 'NA', 'notes' => $booking->notes != '' ? $booking->notes : 'NA', 'notes' => $booking->notes, 'html' => $html);
    }

    public function check_list()
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
        }
        //  else {
        //     $projects = $projects->whereDoesntHave('PassedProjectStatus', function ($query) {
        //         $query->select(DB::raw('count(*)'))->havingRaw('COUNT(*) = ' . DB::RAW("(SELECT COUNT(*)  FROM `project_status_label` WHERE `department_id` = '' OR `department_id` IN (SELECT department_id  FROM `booking_data` WHERE `booking_id` = `bookings`.`id`))"));
        //     });
        // }
        
        if (!empty(request('passed_with_cond'))) {
            $projects =  $projects->whereHas('PassedWithCond', function ($query) {
               
            });
        }
        
        if (!empty(request('q')))
            $projects = $projects->where('address', 'like', '%' . request('q') . '%');
        $projects = $projects->get();
        return view('foreman-project', compact('projects', 'months'));
    }

    public function renderproject(Request $request)
    {

        $project = Booking::find($request->get('id'));
        $department_ids = BookingData::where('booking_id', $request->get('id'))->pluck('department_id');
        $markout_checklist = $project->MarkoutChecklist;
        $checked_checkbox_data = ProjectCheckboxStatus::where('project_id', $request->get('id'))->first();
        if (!empty($checked_checkbox_data)) {
            $checked_checkbox_status = $checked_checkbox_data->status;
        } else {
            $checked_checkbox_status = [];
        }
        $startup_data = $project->StartupChecklist;
        $safety = $project->SafetyPlan;
        $boxing_data = $project->boxing;
        $stripping_data = $project->stripping;
        $incident_data = $project->incident;
        $qaChecklist = QaChecklist::all();
        $pods_steel_label = PodsSteel::all();
        $foreman_images = Image::query();
        $ProjectStatusLabel = ProjectStatusLabel::where(function ($query) use ($department_ids) {
            $query->where('department_id', '=', '')
                ->orWhereIn('department_id', $department_ids);
        })
            ->get();
        $contacts = Contact::all();
        return view('foreman-single-project', compact('foreman_images', 'checked_checkbox_status', 'contacts', 'incident_data', 'pods_steel_label', 'stripping_data', 'safety', 'boxing_data', 'startup_data', 'project', 'qaChecklist', 'markout_checklist', 'ProjectStatusLabel'))->render();
    }

    public function pods_steel(Request $request)
    {
        $res = PodsSteelValue::where('project_id', $request->get('project_id'))->delete();
        $done_by1 = $request->get('done_by1');
        $done_by2 = $request->get('done_by2');
        $checked_by = $request->get('checked_by');
        $project_id = $request->get('project_id');
        $insert_array = [];
        $final_array = [];
        foreach ($done_by1 as $key => $val) {
            $insert_array['project_id'] = $project_id;
            $insert_array['pods_steel_label_id'] = $key;
            $insert_array['done_by1'] = $val != null ? $val : '';
            $insert_array['done_by2'] = $done_by2[$key] != null ? $done_by2[$key] : '';
            $insert_array['checked_by'] = $checked_by[$key] != null ? $checked_by[$key] : '';;
            $final_array[] = $insert_array;
        }
        PodsSteelValue::insert($final_array);
        return redirect()->to('check-list/')->with('succes_msg', 'PODS & Steel Data saved successfuly');
    }

    public function storeQaChecklist(Request $request)
    {
        $res = ProjectQaChecklist::where('project_id', $request->get('project_id'))->delete();
        $initial = $request->get('initial');
        $office_use = $request->get('office_use');
        $project_id = $request->get('project_id');
        $insert_array = [];
        $final_array = [];
        foreach ($initial as $key => $val) {
            $insert_array['project_id'] = $project_id;
            $insert_array['qa_checklist_id'] = $key;
            $insert_array['initial'] = $val != null ? $val : '';
            $insert_array['office_use'] = $office_use[$key] != null ? $office_use[$key] : '';
            $final_array[] = $insert_array;
        }
        ProjectQaChecklist::insert($final_array);
        if (!empty($request->get('onsite_sign'))) {
            QaSign::updateOrCreate(['qa_id' => $project_id], ['foreman_sign' => $request->get('onsite_sign')]);
        }
        return redirect()->to('check-list/')->with('succes_msg', 'Onsite & QA Checklist saved successfuly');
    }


    public function storeMarkoutlist(Request $request)
    {
        $project_id = $request->get('project_id');
        $res = MarkoutChecklist::where('project_id', $project_id)->delete();
        $final_array = $request->get('markout_data');
        $final_array['project_id'] = $project_id;
        MarkoutChecklist::insert($final_array);
        return redirect()->to('check-list/')->with('succes_msg', 'Markout Checklist saved successfuly');
    }

    public function stripping(Request $request)
    {
        $project_id = $request->get('project_id');
        $res = Stripping::where('project_id', $project_id)->delete();
        $final_array = $request->get('stripping_data');
        $final_array['project_id'] = $project_id;
        Stripping::insert($final_array);
        return redirect()->to('check-list/')->with('succes_msg', 'Stripping Data saved successfuly');
    }

    public function storeStartuplist(Request $request)
    {
        $project_id = $request->get('project_id');
        $res = StartupChecklist::where('project_id', $project_id)->delete();
        $final_array = $request->get('startup_data');
        $final_array['project_id'] = $project_id;
        StartupChecklist::insert($final_array);
        return redirect()->to('check-list/')->with('succes_msg', 'Startup Checklist saved successfuly');
    }

    public function accident_investigation(Request $request)
    {
        $project_id = $request->get('project_id');
        $res = Incident::where('project_id', $project_id)->delete();
        $final_array = $request->get('incident_data');
        $final_array['project_id'] = $project_id;
        Incident::insert($final_array);
        return redirect()->to('check-list/')->with('succes_msg', 'Incident data saved successfuly');
    }

    public function boxing(Request $request)
    {
        $project_id = $request->get('project_id');
        $res = Boxing::where('project_id', $project_id)->delete();
        $final_array = $request->get('boxing');
        $final_array['project_id'] = $project_id;
        Boxing::insert($final_array);
        return redirect()->to('check-list/')->with('succes_msg', 'Boxing data saved successfuly');
    }

    public function changeStatus(Request $request)
    {

        $matchThese = ['project_id' => $request->get('project_id'), 'status_label_id' => $request->get('status_label_id')];
        if ($request->get('status') == "") {
            ProjectStatus::where($matchThese)->delete();
            return true;
        }
        $data = ['status' => $request->get('status')];
        if ($request->get('status') == '0' && $request->get('status_label_id') == '10') {
            $data['reason'] = $request->get('reason');
        } else {
            $data['reason'] = '';
        }
        if ($request->get('status') == '3') {
            $data['notes'] = $request->get('notes');
        }

        ProjectStatus::updateOrCreate($matchThese, $data);
        $email_template = ForemanTemplates::where(array('status' => $request->get('status'), 'project_status_label_id' => $request->get('status_label_id')))->get();
        if (count($email_template) > 0) {
            $details['to'] = \config('const.admin1');
            $details['name'] = 'test';
            $details['subject'] = $email_template[0]->subject;
            $details['body'] = $email_template[0]->body;
            dispatch(new BookingEmailJob($details));
        }
        if (($request->get('status_label_id') == '8' || $request->get('status_label_id') == '9' || $request->get('status_label_id') == '10') && $request->get('status') == '0') {
            $address = Booking::find($request->get('project_id'))->address;
            $department_name = ProjectStatusLabel::find($request->get('status_label_id'))->label;
            $contacts = User::whereNotNull('contact')->whereHas("roles", function ($q) {
                $q->where("name", "Project Manager");
            })->orWhere('email', 'andy@boxitfoundations.co.nz')->get();
            $account_sid = \config('const.twilio_sid');;
            $auth_token = \config('const.twilio_token');
            $twilio_number = "+16209129397";
            $client = new Client($account_sid, $auth_token);

            foreach ($contacts as $contact) {
                //echo $contact->contact;
                try {
                    $res = $client->messages->create(
                        // Where to send a text message (your cell phone?)
                        $contact->contact,
                        array(
                            'from' => $twilio_number,
                            'body' => $department_name . ' has been marked as FAILED for Project - ' . $address
                        )
                    );
                    //print_r($res);
                } catch (Exception $e) {
                    //$e->getMessage();
                }
            }
        }
        return true;
    }

    public function safety_plan(Request $request)
    {
        $data = $request->except('_method', '_token');
        $post_data = $data['safety_plan'];
        SafetyPlan::updateOrCreate(['project_id' => $request->get('project_id')], $post_data);
        return redirect()->to('check-list/')->with('succes_msg', 'Safety plan saved successfuly');
    }

    public function foreman_notes(Request $request)
    {
        $id = $request->get('id');
        $date = Carbon::parse($request->get('date'))->toDateTimeString();
        $res = foremanNote::where(array('foreman_id' => $id))->whereDate('date', $date)->get();
        $notes = "";
        if (count($res) > 0)
            $notes = $res[0]->notes;
        return $notes;
    }

    public function save_image(Request $request)
    {
        $image = new Image;
        $image->project_id = $request->project_id;
        $image->form_name = $request->form_name;
        $image->field_id = $request->field_id;
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $file_name = $file->getClientOriginalName();
            $name = time() . rand(1, 100) . '-' . $file_name;
            $file->move('images', $name);
            $image->image = $name;
        }
        $image->save();
        return true;
    }
    public function delete_image(Request $request)
    {
        $image = Image::find($request->id);
        $url = public_path('images/' . $image->image);
        if (file_exists($url)) {
            unlink($url);
        }
        $image->delete();
        return true;
    }
}
