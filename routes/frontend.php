<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


    // ----------------------
    // Home ROUTES
    // ----------------------

     Route::get('/home', [HomeController::class, 'index'])->name('index');
    // Route::prefix('/')->name('brand.')->group(function () {
    //     Route::get('/', [BrandController::class, 'index'])->name('index');
    //     Route::get('/create', [BrandController::class, 'create'])->name('create');
    //     Route::post('/store', [BrandController::class, 'store'])->name('store');
    //     //Route::get('/edit/{brand}', [BrandController::class, 'edit'])->name('edit');
    //     Route::put('/update/{brand}', [BrandController::class, 'update'])->name('update');
    //     Route::delete('/delete/{brand}', [BrandController::class, 'destroy'])->name('destroy');
    // });
