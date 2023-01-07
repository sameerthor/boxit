<?php

namespace App\Http\Controllers;

use App\Models\BookingData;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Contact;
use Spatie\CalendarLinks\Link;
use DateTime;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $departments = Department::all();

        return view('contact', compact('departments'));
    }

    public function contactsbydepartment(Request $request)
    {
        $id = $request->get('department');
        $search = $request->get('search');
        $departments = Department::with(["contacts" => function ($q) use ($search) {
            $q->where('title', 'like', $search . "%");
        }])->find($id);
        return view('contacttable', compact('departments'))->render();
    }

    public function add_contact(Request $request)
    {
        $contact = new Contact();
        $contact->fill($request->all());
        $contact->save();
        return true;
    }
    public function delete_contact(Request $request)
    {
        Contact::destroy($request->get('id'));
        return true;
    }

    public function edit_contact(Request $request)
    {
        return  Contact::find($request->get('id'));
    }

    public function update_contact(Request $request)
    {
        $contact = Contact::find($request->get('id'));
        $contact->email = $request->get('email');
        $contact->title = $request->get('title');
        $contact->company = $request->get('company');
        $contact->contact = $request->get('contact');
        $contact->sms_enabled = $request->get('sms_enabled');
        $contact->save();

        return  true;
    }

    public function vendor($id)
    {
        $contact_id = base64_decode($id);
        return view('vendor', compact('contact_id'));
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
                    $booking_datas = BookingData::whereDate('date', '=', $booking_date)->where('contact_id', $request->get('vendor_id'))
                        ->get();
                    foreach ($booking_datas as $booking_data) {
                        if (!empty($booking_data->booking)) {
                            $address = implode(' ', array_slice(explode(' ', $booking_data->booking->address), 0, 3));
                            switch ($booking_data->status) {
                                case '0':
                                    $class = "orange_bullet monthly_booking";
                                    break;
                                case '1':
                                    $class = "green_bullet monthly_booking";
                                    break;
                                case '2':
                                    $class = "red_bullet monthly_booking";
                                    break;
                                default:
                                    $class = "monthly_booking";
                            }
                            $b_id = $booking_data->booking_id;
                            $inner_html .= "<span class='$class show_booking'  data-id='" . $b_id . "'>$address</span>";
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

    public  function daysInMonth($iMonth, $iYear)
    {
        return cal_days_in_month(CAL_GREGORIAN, $iMonth, $iYear);
    }

    public function  generate_link($id)
    {
        $booking_datas=BookingData::where(['contact_id'=>$id])->get();
        foreach($booking_datas as $res)
        {
            if(!empty($res->date))
            {
            $from = DateTime::createFromFormat('Y-m-d H:i:s',$res->date);
            $to = DateTime::createFromFormat('Y-m-d H:i:s',$res->date);
           if(!empty($from))
           {
            $link = Link::create('Boxit"s booking', $from, $to)
            ->description('Pending')
            ->address('Kruikstraat 22, 2018 Antwerpen');
           }
            
            }
        }

        $link = $link->google();
        return redirect()->to($link);
    }
}
