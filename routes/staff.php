<?php
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\FlashSaleController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductImageGalleryController;
use App\Http\Controllers\Backend\ProductVariantController;
use App\Http\Controllers\Backend\ProductVariantItemController;
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
Route::put('brand/change-status', [BrandController::class, 'changeStatus'])->middleware('staff')->name('brand.change-status');
Route::resource('/staff/brand', BrandController::class)->middleware('staff');

/** Product Resource */
Route::put('product/change-status', [ProductController::class, 'changeStatus'])->middleware('staff')->name('product.change-status');
Route::get('product/sub-category', [ProductController::class, 'getSubCategories'])->middleware('staff')->name('product-get-subcategories');
Route::get('product/child-category', [ProductController::class, 'getChildCategories'])->middleware('staff')->name('product-get-childcategories');
Route::resource('/staff/product', ProductController::class)->middleware('staff');

/** ProductImageGallary Resource */
Route::resource('image-gallery', ProductImageGalleryController::class)->middleware('staff');

/** ProductImageVariant Resource */
Route::put('product-variant/change-status', [ProductVariantController::class, 'changeStatus'])->name('products-variant.change-status');
Route::resource('product-variant', ProductVariantController::class);

/** ProductImageVariant Item Resource */
// Did not use a resource route because we are passing two ID, Product ID and Variant ID
Route::get('product-variant-item/{productId}/{variantId}', [ProductVariantItemController::class, 'index'])->name('product-variant-item.index');
Route::get('product-variant-item/create/{productId}/{variantId}', [ProductVariantItemController::class, 'create'])->name('product-variant-item.create');
Route::post('product-variant-item', [ProductVariantItemController::class, 'store'])->name('products-variant-item.store');
Route::get('product-variant-item-edit/{variantItemId}', [ProductVariantItemController::class, 'edit'])->name('product-variant-item.edit');
Route::put('product-variant-item-update/{variantItemId}', [ProductVariantItemController::class, 'update'])->name('product-variant-item.update');
Route::delete('product-variant-item/{variantItemId}', [ProductVariantItemController::class, 'destroy'])->name('product-variant-item.destroy');
Route::put('product-variant-item-status', [ProductVariantItemController::class, 'chageStatus'])->name('product-variant-item.chages-status');


/** Flash Sale Routes */
Route::get('flash-sale', [FlashSaleController::class, 'index'])->name('flash-sale.index');
Route::put('flash-sale', [FlashSaleController::class, 'update'])->name('flash-sale.update');
Route::post('flash-sale/add-product', [FlashSaleController::class, 'addProduct'])->name('flash-sale.add-product');
Route::put('flash-sale/show-at-home/status-change', [FlashSaleController::class, 'chageShowAtHomeStatus'])->name('flash-sale.show-at-home.change-status');
Route::put('flash-sale-status', [FlashSaleController::class, 'changeStatus'])->name('flash-sale-status');
Route::delete('flash-sale/{id}', [FlashSaleController::class, 'destory'])->name('flash-sale.destory');
