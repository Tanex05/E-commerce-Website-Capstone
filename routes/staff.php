<?php
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\StaffController;
use App\Http\Controllers\Backend\SubCategoryController;
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
Route::put('slider/change-status', [SliderController::class, 'changeStatus'])->middleware('staff')->name('slider.change-status');
Route::resource('/staff/slider', SliderController::class)->middleware('staff');

/** Category Resource */
Route::put('category/change-status', [CategoryController::class, 'changeStatus'])->middleware('staff')->name('category.change-status');
Route::resource('/staff/category', CategoryController::class)->middleware('staff');

/** Sub Category Resource */
Route::put('sub-category/change-status', [SubCategoryController::class, 'changeStatus'])->middleware('staff')->name('sub-category.change-status');
Route::resource('/staff/sub-category', SubCategoryController::class)->middleware('staff');

/** Child Category Resource */
Route::put('child-category/change-status', [ChildCategoryController::class, 'changeStatus'])->middleware('staff')->name('child-category.change-status');
Route::get('get-subcategory', [ChildCategoryController::class, 'getSubCategories'])->middleware('staff')->name('get-subcategories');
Route::resource('/staff/child-category', ChildCategoryController::class)->middleware('staff');

/** Brand Resource */
Route::put('Brand/change-status', [BrandController::class, 'changeStatus'])->middleware('staff')->name('brand.change-status');
Route::resource('/staff/brand', BrandController::class)->middleware('staff');
