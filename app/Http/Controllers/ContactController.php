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
        $departments=Department::all();
        
        return view('contact',compact('departments'));
    }

    public function contactsbydepartment(Request $request)
    {
        $id=$request->get('department');
        $search=$request->get('search');
    //     $departments=Department::whereHas('contacts', function ($query,$search) {
           
    //             $query->where('title', 'like',$search.'%');
            
    //    })->find($id);
    $departments = Department::with(["contacts" => function($q) use ($search) {
        $q->where('title', 'like',$search."%");
    }])->find($id);

   
   return view('contacttable',compact('departments'))->render();
    }
    public function add_contact(Request $request)
    {
        $contact = new Contact();
        $contact->fill($request->all());
        $contact->save();
         return true;        
    }
}
