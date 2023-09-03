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

Route::get('/notify', [App\Http\Controllers\UserController::class, 'notify'])->name('user.notify');
Route::get('/reply/{id}', [App\Http\Controllers\BookingController::class, 'reply']);
Route::get('/change-time', [App\Http\Controllers\BookingController::class, 'change_time']);
Route::get('/test-msg', [App\Http\Controllers\BookingController::class, 'test_msg']);
Route::get('/admin-reply/{id}', [App\Http\Controllers\BookingController::class, 'admin_reply']);
Route::post('/reply', [App\Http\Controllers\BookingController::class, 'reply_confirmation'])->name('mail.reply');
Route::post('/admin-reply', [App\Http\Controllers\BookingController::class, 'admin_reply_confirmation'])->name('admin.reply');

Route::middleware('role_based_redirect')->group(function () {
    Route::get('/', array('as'=>'home', 'uses'=> "App\Http\Controllers\HomeController@index" ));

});

Route::get('/vendors/{id}', [App\Http\Controllers\ContactController::class, 'vendor'])->name('vendor');
Route::get('/vendor-download/{id}', [App\Http\Controllers\ContactController::class, 'generate_link']);
Route::post('/vendor-calender-monthly', [App\Http\Controllers\ContactController::class, 'monthly_calender']);
Route::post('/vendor-modal-data', [App\Http\Controllers\ContactController::class, 'modal_data']);

Route::post('/change-project-status', [App\Http\Controllers\ForemanController::class, 'changeStatus']);
Route::post('/foreman-notes', [App\Http\Controllers\ForemanController::class, 'foreman_notes']);
Route::get('/_mail-viewer/projects-data', function () {
    $projects = \App\Models\Booking::all();
    return $projects;
});

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');

Route::middleware('role:Admin|Project Manager')->group(function () {
    Route::get('/bookings', [App\Http\Controllers\BookingController::class, 'index'])->name('booking');
    Route::post('/reorder', [App\Http\Controllers\BookingController::class, 'reorder'])->name('reorder');
    Route::post('/revised-date', [App\Http\Controllers\BookingController::class, 'revised_date']);
    Route::post('/add-product', [App\Http\Controllers\ProductController::class, 'add_product'])->name('product.add');
    Route::post('/productsbydepartment', [App\Http\Controllers\ProductController::class, 'productsbydepartment'])->name('products.get');
    Route::post('/edit-product', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
    Route::post('/update-product', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::post('/delete-product', [App\Http\Controllers\ProductController::class, 'delete_product'])->name('product.delete');
    Route::get('/new-email/{id}', [App\Http\Controllers\BookingController::class, 'new_booking_email']);
    Route::post('/save-foreman-notes', [App\Http\Controllers\BookingController::class, 'store_foreman_notes']);
    Route::post('/hold-project', [App\Http\Controllers\BookingController::class, 'hold_project']);
    Route::post('/change-calender-colors', [App\Http\Controllers\BookingController::class, 'change_colors']);
     Route::get('/user-management', [App\Http\Controllers\UserController::class, 'index'])->name('user_management');
     Route::post('/users', [App\Http\Controllers\UserController::class, 'users'])->name('user.get');
    Route::post('/add-user', [App\Http\Controllers\UserController::class, 'add_user'])->name('user.add');
    Route::post('/edit-user', [App\Http\Controllers\UserController::class, 'edit_user'])->name('user.edit');
    Route::post('/update-user', [App\Http\Controllers\UserController::class, 'update_user'])->name('user.update');
    Route::post('/delete-user', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');
    Route::post('/get-leaves', [App\Http\Controllers\UserController::class, 'get_leaves'])->name('user.leaves'); 
    Route::post('/save-staffleaves', [App\Http\Controllers\UserController::class, 'save_leaves'])->name('userleaves.save'); 
    Route::post('/user-mail', [App\Http\Controllers\UserController::class, 'mail_user']);
    Route::post('/booking', [App\Http\Controllers\BookingController::class, 'store']);
    Route::post('/save-draft', [App\Http\Controllers\BookingController::class, 'save_draft']);
    Route::get('/delete-draft/{id}', [App\Http\Controllers\BookingController::class, 'delete_draft']);
    Route::get('/draft/{id}', [App\Http\Controllers\BookingController::class, 'draft'])->name('draft');
    Route::get('/drafts', [App\Http\Controllers\BookingController::class, 'drafts'])->name('drafts');
    Route::post('/calender', [App\Http\Controllers\BookingController::class, 'calender']);
    Route::post('/mobile-calender', [App\Http\Controllers\BookingController::class, 'mobile_calender']);
    Route::post('/calender-monthly', [App\Http\Controllers\BookingController::class, 'monthly_calender']);
    Route::post('/calender-daily', [App\Http\Controllers\BookingController::class, 'daily_calender']);
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
    Route::post('/update-project', [App\Http\Controllers\ProjectController::class, 'update_project']);
    Route::post('/delete-file', [App\Http\Controllers\ProjectController::class, 'delete_file']);
    Route::post('/save-image', [App\Http\Controllers\ProjectController::class, 'save_image']);
    Route::post('/save-note', [App\Http\Controllers\ProjectController::class, 'save_note']);
    Route::post('/single-project', [App\Http\Controllers\ProjectController::class, 'renderproject']);
    Route::post('/delete-form', [App\Http\Controllers\ProjectController::class, 'deleteForm']);
    Route::post('/delete-project', [App\Http\Controllers\ProjectController::class, 'delete']);
    Route::post('/change-checkbox-status', [App\Http\Controllers\ProjectController::class, 'change_checkbox_status']);
    Route::get('/job-status', [App\Http\Controllers\JobStatusController::class, 'index'])->name('job_status');
    Route::post('/save-leaves', [App\Http\Controllers\MailController::class, 'save_leave']);
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
            Thank You</br>
            Jules<br><br>
            BOXIT Sales</br>
            <a href="mailto:admin@boxitfoundations.co.nz">admin@boxitfoundations.co.nz</a>
            </br>
            <a href="https://boxitfoundations.co.nz">https://boxitfoundations.co.nz</a></br>'  ;          
            return $html;
        });
    });
    Route::get('/foreman-template/preview/{id}', function ($id) {
        $mailTemplate = \App\Models\ForemanTemplates::find($id);
        return $mailTemplate->body;
    });
    Route::get('/foreman-template/{id}',[App\Http\Controllers\MailController::class, 'foreman_edit']);
    Route::post('/foreman-template/update/{id}',[App\Http\Controllers\MailController::class, 'foreman_update']);

});


Route::middleware('role:Foreman')->group(function () {
  Route::get('/check-list', [App\Http\Controllers\ForemanController::class, 'check_list'])->name('check-list');
  Route::post('/foreman-mobile-calender', [App\Http\Controllers\ForemanController::class, 'mobile_calender']);
  Route::post('/foreman-calender', [App\Http\Controllers\ForemanController::class, 'calender']);
  Route::post('/foreman-calender-monthly', [App\Http\Controllers\ForemanController::class, 'monthly_calender']);
  Route::post('/foreman-calender-daily', [App\Http\Controllers\ForemanController::class, 'daily_calender']);
  Route::post('/foreman-calender-detail', [App\Http\Controllers\ForemanController::class, 'modal_data']);
  Route::post('/foreman-notes-dates', [App\Http\Controllers\ForemanController::class, 'notes_dates']);
  Route::post('/foreman-single-project', [App\Http\Controllers\ForemanController::class, 'renderproject']);
  Route::post('/startup_checklist', [App\Http\Controllers\ForemanController::class, 'storeStartuplist']);
  Route::post('/boxing', [App\Http\Controllers\ForemanController::class, 'boxing']);
  Route::post('/pods-steel', [App\Http\Controllers\ForemanController::class, 'pods_steel']);
  Route::post('/stripping', [App\Http\Controllers\ForemanController::class, 'stripping']);

});

Route::middleware('role:Admin|Project Manager|Foreman')->group(function () {
    Route::get('/contacts', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
    Route::post('/contactsbydepartment', [App\Http\Controllers\ContactController::class, 'contactsbydepartment'])->name('contact.get');
    Route::post('/get-form', [App\Http\Controllers\ForemanController::class, 'getForm']);
    Route::post('/view-form', [App\Http\Controllers\ProjectController::class, 'viewForm']);
    Route::post('/foreman-images', [App\Http\Controllers\ForemanController::class, 'save_image']);
    Route::post('/delete-foreman-image', [App\Http\Controllers\ForemanController::class, 'delete_image']);
    Route::post('/qa_checklist', [App\Http\Controllers\ForemanController::class, 'storeQaChecklist']);
    Route::post('/markout_checklist', [App\Http\Controllers\ForemanController::class, 'storeMarkoutlist']);
    Route::post('/safety-plan', [App\Http\Controllers\ForemanController::class, 'safety_plan']);
    Route::post('/accident-investigation', [App\Http\Controllers\ForemanController::class, 'accident_investigation']);
    Route::post('/create-dateform', [App\Http\Controllers\ForemanController::class, 'create_form']);

});

// User Authentication Routes
Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
Route::get('proxy-login/{id}', 'App\Http\Controllers\Auth\LoginController@proxylogin');
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
