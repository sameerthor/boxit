<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/bookings', [App\Http\Controllers\BookingController::class, 'index'])->name('booking');
Route::post('/booking', [App\Http\Controllers\BookingController::class, 'store']);
Route::get('/contacts', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/add-contact', [App\Http\Controllers\ContactController::class, 'add_contact'])->name('contact.add');
Route::post('/update-contact', [App\Http\Controllers\ContactController::class, 'update_contact'])->name('contact.update');
Route::post('/edit-contact', [App\Http\Controllers\ContactController::class, 'edit_contact'])->name('contact.edit');
Route::post('/delete-contact', [App\Http\Controllers\ContactController::class, 'delete_contact'])->name('contact.delete');
Route::post('/contactsbydepartment', [App\Http\Controllers\ContactController::class, 'contactsbydepartment'])->name('contact.get');
Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('project');
Route::post('/single-project', [App\Http\Controllers\ProjectController::class, 'renderproject']);
Route::get('/job-status', [App\Http\Controllers\JobStatusController::class, 'index'])->name('job_status');
Route::group(['prefix' => 'mail-template'], function() {
    Route::get('/', [App\Http\Controllers\MailController::class,'index'])->name('mail_template');
    Route::get('/{id}', [App\Http\Controllers\MailController::class,'edit']);
    Route::post('/update/{id}', [App\Http\Controllers\MailController::class,'update']);
    Route::get('/preview/{id}', function ($id) {
        $mailTemplate = \App\Models\MailTemplate::find($id);
        return $mailTemplate->body;
    });
});
