<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::all();
        return view('user', compact('users'));
    }

    public function add_user(Request $request)
    {
        $contact = new User();
        $contact->fill($request->all());
        $contact->save();
        return true;
    }
    
    public function edit_user(Request $request)
    {
        return  User::find($request->get('id'));
    }

    public function update_contact(Request $request)
    {
        $contact = User::find($request->get('id'));
        $contact->email = $request->get('email');
        $contact->title = $request->get('title');
        $contact->company = $request->get('company');
        $contact->contact = $request->get('contact');
        $contact->sms_enabled = $request->get('sms_enabled');
        $contact->save();

        return  true;
    }

}
