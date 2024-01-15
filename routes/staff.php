<?php
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\StaffController;
use Illuminate\Support\Facades\Route;


/** Admin Route */


/** Employee Route */


/** Staff Route (Admin & Employee) */
Route::get('staff/dashboard', [StaffController::class, 'dashboard'])->middleware('staff')->name('staff.dashboard');


/** Profile Route */
Route::get('/profile/staff', [ProfileController::class, 'index'])->middleware('staff')->name('staff.profile');
Route::post('profile/update', [ProfileController::class, 'updateProfile'])->middleware('staff')->name('staff.profile.update');
Route::post('profile/update/password', [ProfileController::class, 'updatePassword'])->middleware('staff')->name('staff.password.update');


