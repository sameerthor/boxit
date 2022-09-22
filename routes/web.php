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
Route::get('/contacts', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/add-contacts', [App\Http\Controllers\ContactController::class, 'add_contact'])->name('contact.add');
Route::post('/contactsbydepartment', [App\Http\Controllers\ContactController::class, 'contactsbydepartment'])->name('contact.get');
Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('project');
Route::get('/job-status', [App\Http\Controllers\JobStatusController::class, 'index'])->name('job_status');
