<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Frontend\FlashOutController;
use App\Http\Controllers\Backend\StaffController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\FrontendProductController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserAddressController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('flash-sale/page', [FlashSaleController::class, 'index'])->name('flash-sale');
Route::get('flash-out/page', [FlashOutController::class,'index'])->name('flashout');

Route::get('/staff/login', [StaffController::class, 'login'])->name('staff.login');

/** Product route */
// Route::get('products', [FrontendProductController::class, 'productsIndex'])->name('products.index');
Route::get('product-detail/{slug}', [FrontendProductController::class, 'showProduct'])->name('product-detail');
// Route::get('change-product-list-view', [FrontendProductController::class, 'chageListView'])->name('change-product-list-view');

/** User Routes */
Route::group(['middlware'=> ['auth', 'verified'] , 'prefix' => 'user', 'as' => 'user.'] , function(){
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [UserProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile', [UserProfileController::class, 'updatePassword'])->name('profile.password');

    /** User Address Routes */
    Route::resource('address', UserAddressController::class);
});

