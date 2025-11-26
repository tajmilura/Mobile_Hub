<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

//tajjjjjjjjjj

Route::get('/taj', function () {
    return view('taj');
});

Route::get('/alif', function () {
    return view('bin');
});

// Route::get('/home', function () {
//     return view('frontend.index');
// });



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::get('/profile/new', function () {
    return view('frontend.profile.profile');
})->middleware(['auth'])->name('profile');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('frontend.dashboard');
    })->name('dashboard');
});


// Test Route
Route::get('/test', function () {
    return view('admin.index');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/frontend.php';
