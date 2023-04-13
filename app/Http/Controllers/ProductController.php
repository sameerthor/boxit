<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Product;
use Session;

class ProductController extends Controller
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
        $products = Product::where("department_id",1)->get();
        return view('product', compact('departments','products'));
    }

    public function edit(Request $request)
    {
        return  Product::find($request->get('id'));
    }
    
    public function productsbydepartment(Request $request)
    {
        $id = $request->get('department');
        $search = $request->get('search');
        $products = Product::where(["department_id" => $id])->where('title', 'like', $search . "%")->get();
        return view('producttable', compact('products'))->render();
    }

    public function add_product(Request $request)
    {
        $product = new Product;
        $product->title = $request->get('title');
        $product->description = $request->get('description');
        $product->department_id = $request->get('department_id');
        if($request->hasfile('image'))
        {
            $file=$request->file('image');
            $file_name = $file->getClientOriginalName();
            $name = time() . rand(1, 100) . '-' . $file_name;
            $file->move('images', $name);
            $product->image = $name;
        }
        $product->save();
        Session::flash('succes_msg', 'Product has been saved successfuly.');

        return  true;
    }

    public function update(Request $request)
    {
        $department = Product::find($request->get('id'));
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
        Session::flash('succes_msg', 'Product has been saved successfuly.');

        return  true;
    }

    public function delete_product(Request $request)
    {
        Product::destroy($request->get('id'));
        return true;
    }
}
