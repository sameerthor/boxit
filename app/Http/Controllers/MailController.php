<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\MailTemplate;

class MailController extends Controller
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
        $templates = MailTemplate::all();
        return view('mailtemplate', compact('templates'));
    }

    public function edit(Request $request, $id)
    {
        $template = MailTemplate::find($id);
        return view('edittemplate', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $mailTemplate = MailTemplate::find($id);
        $mailTemplate->subject = $request->get('subject');
        $mailTemplate->body = $request->get('body');
        if(!empty($request->get('product')))
        {
            $mailTemplate->products = array_column($request->get('product'),'name');
        }
        $mailTemplate->save();
        return redirect()->to('/mail-template')->with('succes_msg', 'Your template has been saved.');
    }

    public function mail_status(Request $request)
    {
        $mailTemplate = MailTemplate::find($request->get('id'));
        $mailTemplate->status = $request->get('status')=='true'?'1':0;
        $mailTemplate->save();
        return array('success'=>true);
    }
}
