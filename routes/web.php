<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{LocationController, ProfileController};

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // route khusus untuk location
    Route::get('/locations', [LocationController::class, 'index'])->name('location.index');
    Route::post('/locations', [LocationController::class, 'store'])->name('location.store');
    Route::get('/locations/detail/{param}', [LocationController::class, 'show'])->name('location.show');

    

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
