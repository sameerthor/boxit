<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Contact;

class ContactController extends Controller
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
        print_r($request->all());
        $contact->email = $request->get('email');
        $contact->title = $request->get('title');
        $contact->contact = $request->get('contact');
        $contact->sms_enabled = $request->get('sms_enabled');
        $contact->save();

        return  true;
    }
}
