<?php
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\StaffController;
use Illuminate\Support\Facades\Route;


/** Admin Route */


/** Employee Route */


/** Staff Route (Admin & Employee) */
Route::get('staff/dashboard', [StaffController::class, 'dashboard'])->middleware('staff')->name('staff.dashboard');


/**Staff Profile Route */
Route::group(['middlware'=>'staff', 'as' => 'staff.'] , function(){
    Route::get('/profile/staff', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

/** Slider Resource */
Route::resource('/staff/slider', SliderController::class)->middleware('staff');

/** Category Resource */
Route::put('change-status', [CategoryController::class, 'changeStatus'])->middleware('staff')->name('category.change-status');
Route::resource('/staff/category', CategoryController::class)->middleware('staff');
