<?php

namespace App\Http\Controllers;

use App\Models\BookingData;
use Illuminate\Http\Request;
use App\Models\Contact;
use Carbon\Carbon;
use Excel;
use Maatwebsite\Excel\Excel as BaseExcel;
use App\Exports\ExampleExportView;
use Mail;
use App\Mail\BookingMail;
use Session;
use Redirect;
use DB;
class ConcreteController extends Controller
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
        $concrete_bookings = BookingData::has('booking')->whereHas('contact', function ($query) {
            return $query->whereNot('title', 'N/A')->whereNot('title', 'To Be Confirmed');
        })->where("department_id", "8")->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('date')->get();
        $contact_ids = $concrete_bookings->pluck('contact_id')->toArray();
        $concrete_contacts = Contact::where("department_id", "8")->whereIn('id', $contact_ids)->whereNot('title', 'N/A')->whereNot('title', 'To Be Confirmed')->get();
        $byweek = BookingData::whereDate('date','>=',Carbon::now())->groupBy(DB::raw('WEEK(date)'))
        ->orderBy(DB::raw('WEEK(date)'))->get();
        return view('concrete', compact('concrete_contacts', 'concrete_bookings','byweek'));
    }

    public function concrete_table(Request $request)
    {
        $contact_id = $request->get('contact_id');
        $week_date = $request->get('week_date');
        $start=Carbon::parse($week_date)->startOfWeek();
        $end=Carbon::parse($week_date)->endOfWeek();
        if (!empty($contact_id)) {
            $concrete_bookings = BookingData::has('booking')->where("department_id", "8")->where('contact_id', $contact_id)->whereBetween('date', [$start, $end])->orderBy('date')->get();
        } else {
            $concrete_bookings = BookingData::has('booking')->whereHas('contact', function ($query) {
                return $query->whereNot('title', 'N/A')->whereNot('title', 'To Be Confirmed');
            })->where("department_id", "8")->whereBetween('date', [$start, $end])->orderBy('date')->get();
        }
        $table_html = "";
        foreach ($concrete_bookings as $res) {
            $table_html .= "<tr><th>$res->date</th><th>" . $res->booking->address . "</th><th></th><th>" . $res->contact->title . "</th></tr>";
        }
        $modal_html = "";
        $option_html = '<option value="0">All Concrete</option>';
        $all_concretes = BookingData::whereHas('contact', function ($query) {
            return $query->whereNot('title', 'N/A')->whereNot('title', 'To Be Confirmed');
        })->where("department_id", "8")->whereBetween('date', [$start, $end])->groupBy('contact_id')->orderBy('date')->get();
        foreach ($all_concretes as $res) {
            $modal_html .= '<tr><th>'.$res->contact?->title.'</th><th><a href="/concrete-download/'.$res->contact?->id.'/'.$week_date.'"  class="download-button btn btn-sm btn-info btn-color">Download</a> <a href="/concrete-email/'.$res->contact?->id.'/'.$week_date.'" class="btn btn-sm btn-info btn-color">Email</a></th> </tr>';
            $selected=$res->contact?->id==$contact_id?'selected':'';
            $option_html.= '<option value="'.$res->contact?->id.'" '.$selected.'>'.$res->contact?->title.'</option>';
        }
        return json_encode(array('modal_html'=>$modal_html,'table_html'=>$table_html,'option_html'=>$option_html));
    }

    public function download_sheet($contact_id,$week_date)
    {
        $filename = "concrete";
        $start=Carbon::parse($week_date)->startOfWeek();
        $end=Carbon::parse($week_date)->endOfWeek();
        $concrete_bookings = BookingData::where("department_id", "8")->has('booking')->where('contact_id', $contact_id)->whereBetween('date', [$start, $end])->orderBy('date')->get();
        ;
        $concrete_bookings = $concrete_bookings->mapToGroups(function ($item) {
            return [date('l', strtotime($item['date'])) => $item]; // assuming 'locale' key
        });
        $data['contact_name'] = Contact::find($contact_id)->title;
        $data['bookings'] = $concrete_bookings;
        // dd($data['bookings']['Friday'][0]->booking);
        return Excel::download(
            new ExampleExportView($data),
            $filename . '.xlsx'
        );
    }

    public function send_email($contact_id,$week_date)
    {
        $contact = Contact::find($contact_id);
        $start=Carbon::parse($week_date)->startOfWeek();
        $end=Carbon::parse($week_date)->endOfWeek();
        if(empty($contact->concrete_email))
        {
            Session::flash('error_msg', "Concrete email is empty.");
            return Redirect::back();
                }
        $filename = "concrete";

        $concrete_bookings = BookingData::has('booking')->where("department_id", "8")->where('contact_id', $contact_id)->whereBetween('date', [$start, $end])->orderBy('date')->get();
        ;
        $concrete_bookings = $concrete_bookings->mapToGroups(function ($item) {
            return [date('l', strtotime($item['date'])) => $item]; // assuming 'locale' key
        });
        $data['contact_name'] = $contact->title;
        $data['bookings'] = $concrete_bookings;
        $files = Excel::download(
            new ExampleExportView($data),
            'concrete.xlsx'
        )->getFile();
        $html='Hello,<br>Please find attached the booking details & order for the week of '.$start->format('d/m').' to '.$end->format('d/m').'.';
        $html .= '<br>Thank You,<br>
                Andy<br><br>
                <img src="https://boxit.staging.app/img/logo2581-1.png" style="width:75px;height:30px" class="mail-logo" alt="Boxit Logo">

                ';
        Mail::to($contact->concrete_email)
            ->send(new BookingMail(['to'=>$contact->concrete_email,'files'=>[$files],'body'=>$html]));
            Session::flash('succes_msg', 'Mail sent successfuly.');
            return Redirect::back();
    }
}
