<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Mobilehub\AIController;
use App\Http\Controllers\Mobilehub\BrandController;
use App\Http\Controllers\Mobilehub\ProductController;
use App\Http\Controllers\Mobilehub\CategoryController;
use App\Http\Controllers\Mobilehub\DashboardController;
use App\Http\Controllers\Mobilehub\AdminOrderController;
use App\Http\Controllers\Mobilehub\AdminCouponController;
use App\Http\Controllers\Mobilehub\AdminProfileController;
use App\Http\Controllers\Mobilehub\AdminUserController;
use App\Http\Controllers\Mobilehub\SliderBannerController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('ad_dashboard')
    //    ->name('dashboard_ad')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin_dashboard');
        Route::resource('brands', BrandController::class);
        Route::resource('products', ProductController::class);
    });


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    //    ->name('dashboard_ad')
    ->group(function () {
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::patch('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
        Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('admin.profile.destroy');
        Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('admin.profile.destroy');
        Route::put('/password/update-custom', [AdminProfileController::class, 'updatePassword'])->name('admin.password.update.custom');
    });

//
// Now For Products Management
//

Route::middleware(['auth', 'role:admin'])->group(function () {

    // ----------------------
    // BRAND ROUTES
    // ----------------------
    Route::prefix('brand')->name('brand.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        //Route::get('/edit/{brand}', [BrandController::class, 'edit'])->name('edit');
        Route::put('/update/{brand}', [BrandController::class, 'update'])->name('update');
        Route::delete('/delete/{brand}', [BrandController::class, 'destroy'])->name('destroy');
    });

    // ----------------------
    // CATEGORY ROUTES
    // ----------------------
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        // Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('edit'); // Optional if using same form
        Route::put('/update/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/delete/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });
    // ----------------------
    // Product ROUTES
    // ----------------------
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::delete('/delete/edit_image/{product}', [ProductController::class, 'Image_destroy'])->name('image_destroy');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('edit'); // Optional if using same form
        Route::put('/update/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/delete/{product}', [ProductController::class, 'destroy'])->name('destroy');
        Route::get('/products/{id}', [ProductController::class, 'show'])->name('show');
    });



    // Order Routes
    Route::prefix('admin')->group(function () {
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('order.all_order');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('order.show');
        Route::get('/orders/{id}/edit', [AdminOrderController::class, 'edit'])->name('order.edit');
        // Route::put('/orders/{id}', [AdminOrderController::class, 'update'])->name('order.update');
        Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('order.destroy');
        Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('order.updateStatus');
    });

    // ----------------------
    // Slider & Banner ROUTES
    // ----------------------
    Route::prefix('slider_banner')->name('slider_banner.')->group(function () {
        Route::get('/', [SliderBannerController::class, 'index'])->name('index');
        Route::get('/create', [SliderBannerController::class, 'create'])->name('create');
        Route::post('/store', [SliderBannerController::class, 'store'])->name('store');
        Route::get('/edit/{slider_banner}', [SliderBannerController::class, 'edit'])->name('edit'); // Optional if using same form
        Route::put('/update/{slider_banner}', [SliderBannerController::class, 'update'])->name('update');
        Route::delete('/delete/{slider_banner}', [SliderBannerController::class, 'destroy'])->name('destroy');
    });

    //setting route can be here
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/update', [SettingController::class, 'update'])->name('update');
    });


    // Coupon Resource Routes (CRUD Operations)
    Route::resource('coupons', AdminCouponController::class);

    // Additional Custom Routes
    Route::post('/coupons/{coupon}/toggle-status', [AdminCouponController::class, 'toggleStatus'])->name('coupons.toggle-status');








    // User Management Routes
    Route::prefix('admin')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

        // User Actions
        Route::post('/users/{id}/make-admin', [AdminUserController::class, 'makeAdmin'])->name('admin.users.makeAdmin');
        Route::post('/users/{id}/remove-admin', [AdminUserController::class, 'removeAdmin'])->name('admin.users.removeAdmin');
        Route::post('/users/{id}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggleStatus');

        // Email Search
        Route::post('/users/search-by-email', [AdminUserController::class, 'searchByEmail'])->name('admin.users.searchByEmail');
        Route::post('/users/make-admin-by-email', [AdminUserController::class, 'makeAdminByEmail'])->name('admin.users.makeAdminByEmail');
    });





    // Admin maintenance toggle route
    Route::post('/admin/toggle-maintenance', function () {
        $newStatus = \App\Models\Setting::toggleMaintenanceMode();

        return response()->json([
            'success' => true,
            'maintenance_mode' => $newStatus,
            'message' => $newStatus ? 'Maintenance mode enabled' : 'Maintenance mode disabled'
        ]);
    })->middleware('auth')->name('admin.toggleMaintenance');
});
