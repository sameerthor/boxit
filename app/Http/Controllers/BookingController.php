<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingData;

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
        $foreman = User::whereHas("roles", function($q){ $q->where("name", "Foreman"); })->get();
        return view('booking',compact('departments','foreman'));
    }

    public function store(Request $request)
    {

        $booking = new Booking;
        $booking->address=$request->get('address');
        $booking->floor_area = $request->get('floor_area');
        $booking->floor_type = $request->get('floor_type');
        $booking->notes = $request->get('notes');
        $booking->foreman_id = $request->get('foreman');
        if($files=$request->file('file_upload')){  
            $name=$files->getClientOriginalName();  
            $files->move('images',$name);  
            $booking->file=$name;  
            }  
        $booking->save();

         $booking_id=$booking->id;
         $requested_date=$request->get('date');
         foreach($request->get('department') as $key=>$val)
         {
            BookingData::create(array(
                'department_id' => $key,
                'contact_id'  => $val,
                'date' => @$requested_date[$key],
                'booking_id'=> $booking_id
            ));
         }

         return redirect()->route('project')->with('succes_msg', 'Your booking has been saved.');


    }

}
