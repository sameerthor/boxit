<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StaffLeave;
use Auth;
use App\Jobs\BookingEmailJob;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('user', compact('users'));
    }

    public function edit_user(Request $request)
    {
        return  User::find($request->get('id'));
    }

    public function users(Request $request)
    {
        $search = $request->get('search');
        $users = User::where('name', 'like', $search . '%')->get();
        return view('usertable', compact('users'))->render();
    }

    public function add_user(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->contact = $request->contact;
        $user->save();
        $user = $user->fresh();
        $user->assignRole($request->user_type);
        return true;
    }



    public function update_user(Request $request)
    {
        $user = User::find($request->get('id'));
        $user->name = $request->name;
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->roles()->detach();
        $user->assignRole($request->user_type);
        $user->email = $request->email;
        $user->contact = $request->contact;
        $user->save();

        return  true;
    }

    public function notify()
    {
        $user = User::find(Auth::id());
        $user->last_notify = Carbon::now()->toDateTimeString();;
        $user->save();
    }

    public function mail_user(Request $request)
    {
        $body = $request->mail;
        $emails = $request->emails;
        if (empty($emails))
            $emails = User::all()->pluck('email');
        foreach ($emails as $res) {
            $details['to'] = $res;
            $details['url'] = 'testing';
            $details['subject'] = 'Notification';
            $details['body'] = $body;
            $details['files'] = [];
            dispatch(new BookingEmailJob($details));
        }

        Session::flash('succes_msg', 'Mail has been sent successfuly.');
        return redirect('/user-management');
    }

    public function get_leaves(Request $request)
    {
        $staff_id = $request->get('id');
        $data = StaffLeave::where('staff_id', $staff_id)->get();
        return $data;
    }

    public function save_leaves(Request $request)
    {

        $staff_id = $request->get('id');
        StaffLeave::where('staff_id', $staff_id)->delete();
        $from_dates = $request->get('from_dates');
        $to_dates = $request->get('to_dates');
        $i = 0;
        foreach ($from_dates as $date) {
            StaffLeave::create(array('staff_id' => $staff_id, 'to_date' => date("Y-m-d h:i:s", strtotime($to_dates[$i])), 'from_date' => date("Y-m-d h:i:s", strtotime($date))));
            $i++;
        }
        return true;
    }

    public function delete(Request $request)
    {
        $random = Str::random(8);

        User::where('id', $request->get('id'))->update(['email' => $random . '@boxit.com']);
        User::find($request->get('id'))->delete();
        return true;
    }
}
