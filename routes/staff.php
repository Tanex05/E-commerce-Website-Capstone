<?php

/** Staff Route */

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\StaffController;
use Illuminate\Support\Facades\Route;


/** Admin Route */


/** Employee Route */


/** Staff Route (Admin & Employee) */
Route::get('staff/dashboard', [StaffController::class, 'dashboard'])->middleware('staff')->name('staff.dashboard');



