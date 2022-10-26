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
use App\Models\SafetyPlan;
use Auth;
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
            $foreman = User::where("id",Auth::id())->get();
            foreach ($foreman as $res) {
                $booking_data = Booking::where(array('foreman_id' => $res->id))->whereDate('created_at', '=', date('Y-m-d', strtotime($booking_date)))->first();
                if (!empty($booking_data)) {
                    $html .= "<div class='booked_div green_box show_booking' data-id='" . $booking_data->id . "'>" . $booking_data->address . "</div>";
                } else {
                    $html .= "<div class='booked_div'></div>";
                }
            }
            $department_id = array(2, 3, 4, 5, 6, 7, 8, 9, 10);
            foreach ($department_id as $id) {
                $booking_data = BookingData::whereHas('booking', function($q) {
                    $q->where('foreman_id',Auth::id());
                })->where(array('department_id' => $id))->whereDate('date', '=',$booking_date)->first();
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

    public function check_list()
    {
        $projects=Booking::where(array('foreman_id'=>Auth::id()))->get();
        return view('foreman-project',compact('projects'));

    }

    public function renderproject(Request $request )
    {   
        $project=Booking::find($request->get('id'));
        $markout_checklist=$project->MarkoutChecklist;
        $safety=$project->SafetyPlan;
        $qaChecklist=QaChecklist::all();
        $ProjectStatusLabel=ProjectStatusLabel::all();
        return view('foreman-single-project',compact('safety','project','qaChecklist','markout_checklist','ProjectStatusLabel'))->render();
    }

    public function storeQaChecklist(Request $request )
    {   
        $res=ProjectQaChecklist::where('project_id',$request->get('project_id'))->delete();
        $initial=$request->get('initial');
        $office_use=$request->get('office_use');
        $project_id=$request->get('project_id');
        $insert_array=[];
        $final_array=[];
        foreach($initial as $key=>$val)
        {
            $insert_array['project_id']=$project_id;
            $insert_array['qa_checklist_id']=$key;
            $insert_array['initial']=$val!=null?$val:'';
            $insert_array['office_use']=$office_use[$key]!=null?$office_use[$key]:'';
            $final_array[]=$insert_array;
        }
        ProjectQaChecklist::insert($final_array);
        return redirect()->to('check-list/')->with('succes_msg', 'Onsite & QA Checklist saved successfuly');

    }

    
    public function storeMarkoutlist(Request $request )
    {   
        $project_id=$request->get('project_id');
        $res=MarkoutChecklist::where('project_id',$project_id)->delete();
        $final_array=$request->get('markout_data');
        $final_array['project_id']=$project_id;
        MarkoutChecklist::insert($final_array);
        return redirect()->to('check-list/')->with('succes_msg', 'Markout Checklist saved successfuly');

    }

    public function changeStatus(Request $request)
    {
        $matchThese = ['project_id'=>$request->get('project_id'),'status_label_id'=>$request->get('status_label_id')];
        
        ProjectStatus::updateOrCreate($matchThese,['status'=>$request->get('status')]);
        $email_template=ForemanTemplates::where(array('status'=>$request->get('status'),'project_status_label_id'=>$request->get('status_label_id')))->get();
      if(count($email_template)>0)
      {
        $details['to'] = env('ADMIN_EMAIL');;
        $details['name'] = 'test';
        $details['subject'] = $email_template[0]->subject;
        $details['body'] =$email_template[0]->body;
        dispatch(new BookingEmailJob($details));
      }  
        return true;
    } 

    public function safety_plan(Request $request)
    {
      $data=$request->except('_method', '_token');
      $post_data=$data['safety_plan'];
      SafetyPlan::updateOrCreate(['project_id'=>$request->get('project_id')],$post_data);
      return redirect()->to('check-list/')->with('succes_msg', 'Safety plan saved successfuly');

    }
}
