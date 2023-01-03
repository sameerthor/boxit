<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Carbon\Carbon;
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
        $users = User::where('name','like', $search.'%')->get();
        return view('usertable', compact('users'))->render();
    }

    public function add_user(Request $request)
    {
        $user = new User();
        $user->name=$request->name;
        $user->password=$request->password;
        $user->email=$request->email;
        $user->save();
        $user = $user->fresh();
        $user->assignRole($request->user_type);
        return true;
    }
    
    

    public function update_user(Request $request)
    {
        $user = User::find($request->get('id'));
        $user->name=$request->name;
        if(!empty($request->password))
        {
        $user->password=$request->password;
        }
        $user->email=$request->email;
        $user->save();

        return  true;
    }

    public function notify()
    {
        $user = User::find(Auth::id());
        $user->last_notify = Carbon::now()->toDateTimeString();;
        $user->save();
    }

}
