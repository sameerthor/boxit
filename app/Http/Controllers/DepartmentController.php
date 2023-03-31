<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Session;

class DepartmentController extends Controller
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

        return view('product', compact('departments'));
    }

    public function edit(Request $request)
    {
        return  Department::find($request->get('id'));
    }

    public function update(Request $request)
    {
        $department = Department::find($request->get('id'));
        $department->title = $request->get('title');
        $department->description = $request->get('description');
        if($request->hasfile('image'))
        {
            $file=$request->file('image');
            $file_name = $file->getClientOriginalName();
            $name = time() . rand(1, 100) . '-' . $file_name;
            $file->move('images', $name);
            $department->image = $name;
        }
        $department->save();
        Session::flash('succes_msg', 'Department has been saved successfuly.');

        return  true;
    }

    
}
