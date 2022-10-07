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

        $mailTemplate->title = $request->get('title');
        $mailTemplate->subject = $request->get('subject');
        $mailTemplate->body = $request->get('body');
        $mailTemplate->save();
        return redirect()->to('/mail-template')->with('succes_msg', 'Your template has been saved.');
    }
}
