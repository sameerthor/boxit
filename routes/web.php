<?php

use Illuminate\Support\Facades\Route;
use App\Jobs\BookingEmailJob;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/reply/{id}', [App\Http\Controllers\BookingController::class, 'reply']);
Route::get('/admin-reply/{id}', [App\Http\Controllers\BookingController::class, 'admin_reply']);
Route::post('/reply', [App\Http\Controllers\BookingController::class, 'reply_confirmation'])->name('mail.reply');
Route::post('/admin-reply', [App\Http\Controllers\BookingController::class, 'admin_reply_confirmation'])->name('admin.reply');

Route::middleware('role_based_redirect')->group(function () {
    Route::get('/', array('as'=>'home', 'uses'=> "App\Http\Controllers\HomeController@index" ));

});

Route::middleware('role:Admin')->group(function () {
    Route::get('/bookings', [App\Http\Controllers\BookingController::class, 'index'])->name('booking');
    Route::post('/revised-date', [App\Http\Controllers\BookingController::class, 'revised_date']);
    Route::post('/booking', [App\Http\Controllers\BookingController::class, 'store']);
    Route::post('/save-draft', [App\Http\Controllers\BookingController::class, 'save_draft']);
    Route::get('/delete-draft/{id}', [App\Http\Controllers\BookingController::class, 'delete_draft']);
    Route::get('/draft/{id}', [App\Http\Controllers\BookingController::class, 'draft'])->name('draft');
    Route::get('/drafts', [App\Http\Controllers\BookingController::class, 'drafts'])->name('drafts');
    Route::post('/calender', [App\Http\Controllers\BookingController::class, 'calender']);
    Route::post('/calender-monthly', [App\Http\Controllers\BookingController::class, 'monthly_calender']);
    Route::post('/calender-detail', [App\Http\Controllers\BookingController::class, 'modal_data']);
    Route::post('/send-mail', [App\Http\Controllers\BookingController::class, 'send_mail'])->name('send_mail');

    Route::get('/booking/{id}', [App\Http\Controllers\BookingController::class, 'booking']);
    Route::get('/contacts', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
    Route::post('/add-contact', [App\Http\Controllers\ContactController::class, 'add_contact'])->name('contact.add');
    Route::post('/update-contact', [App\Http\Controllers\ContactController::class, 'update_contact'])->name('contact.update');
    Route::post('/edit-contact', [App\Http\Controllers\ContactController::class, 'edit_contact'])->name('contact.edit');
    Route::post('/delete-contact', [App\Http\Controllers\ContactController::class, 'delete_contact'])->name('contact.delete');
    Route::post('/contactsbydepartment', [App\Http\Controllers\ContactController::class, 'contactsbydepartment'])->name('contact.get');
    Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('project');
    Route::post('/single-project', [App\Http\Controllers\ProjectController::class, 'renderproject']);
    Route::post('/delete-project', [App\Http\Controllers\ProjectController::class, 'delete']);
    Route::get('/job-status', [App\Http\Controllers\JobStatusController::class, 'index'])->name('job_status');
    Route::group(['prefix' => 'mail-template'], function () {
        Route::get('/', [App\Http\Controllers\MailController::class, 'index'])->name('mail_template');
        Route::post('/', [App\Http\Controllers\MailController::class, 'mail_status'])->name('mail.update');
        Route::get('/{id}', [App\Http\Controllers\MailController::class, 'edit']);
        Route::post('/update/{id}', [App\Http\Controllers\MailController::class, 'update']);
        Route::get('/preview/{id}', function ($id) {
            $mailTemplate = \App\Models\MailTemplate::find($id);
            $html=$mailTemplate->body;
            if(!empty($mailTemplate->products))
						{
                            $html.="<br>";
						foreach($mailTemplate->products as $product)
						{
                            $html.="<p class='product'>$product- [qty]</p>";
						}
						}
            $html.='<br>
            For<br>
            [address]
            <br>
            <br>
            At
            <br>[date]
            <br>[time]
            <br><br>
            [link]
            <br>
            Thanks,</br>
            Jules,</br>
            BOXIT Sales</br>
            <a href="mailto:admin@boxitfoundations.co.nz">admin@boxitfoundations.co.nz</a>
            </br>
            <a href="https://boxitfoundations.co.nz
">https://boxitfoundations.co.nz</a></br>'  ;          
            return $html;
        });
    });
    Route::get('/foreman-template/preview/{id}', function ($id) {
        $mailTemplate = \App\Models\ForemanTemplates::find($id);
        return $mailTemplate->body;
    });
    Route::get('/foreman-template/{id}',[App\Http\Controllers\MailController::class, 'foreman_edit']);
    Route::post('/foreman-template/update/{id}',[App\Http\Controllers\MailController::class, 'foreman_update']);

    Route::get('/send', function () {
        $details['to'] = 'khanayan36042@gmail.com';
        $details['name'] = 'Sameer';
        $details['url'] = 'testing';
        $details['subject'] = 'testing';
        $details['body'] = 'This is test message.';
        dispatch(new BookingEmailJob($details));
    });
});

Route::middleware('role:Foreman')->group(function () {
  Route::get('/check-list', [App\Http\Controllers\ForemanController::class, 'check_list'])->name('check-list');
  Route::post('/foreman-calender', [App\Http\Controllers\ForemanController::class, 'calender']);
  Route::post('/foreman-calender-detail', [App\Http\Controllers\ForemanController::class, 'modal_data']);
  Route::post('/foreman-single-project', [App\Http\Controllers\ForemanController::class, 'renderproject']);
  Route::post('/qa_checklist', [App\Http\Controllers\ForemanController::class, 'storeQaChecklist']);
  Route::post('/markout_checklist', [App\Http\Controllers\ForemanController::class, 'storeMarkoutlist']);
  Route::post('/change-project-status', [App\Http\Controllers\ForemanController::class, 'changeStatus']);
  Route::post('/safety-plan', [App\Http\Controllers\ForemanController::class, 'safety_plan']);
});


// User Authentication Routes
Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// User Registration Routes
Route::get('register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'App\Http\Controllers\Auth\RegisterController@register');

// User Password Reset Routes
Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');

// User Verification Routes
Route::get('email/verify', 'App\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');
