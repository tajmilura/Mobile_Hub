<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobilehub\BrandController;
use App\Http\Controllers\Mobilehub\ProductController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('ad_dashboard')
//    ->name('dashboard_ad')
    ->group(function () {
        Route::get('/', fn() => view('admin.index'))->name('admin_dashboard');
        Route::resource('brands', BrandController::class);
        Route::resource('products', ProductController::class);
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
        Route::get('/edit/{brand}', [BrandController::class, 'edit'])->name('edit');
        Route::put('/update/{brand}', [BrandController::class, 'update'])->name('update');
        Route::delete('/delete/{brand}', [BrandController::class, 'destroy'])->name('destroy');
    });
});

