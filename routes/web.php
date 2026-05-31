<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{ItemController, LocationController, ProfileController};

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
    Route::put('/locations/update/{param}', [LocationController::class, 'update'])->name('location.update');
    Route::delete('/locations/delete/{param}', [LocationController::class, 'delete'])->name('location.delete');

     // route khusus untuk items
    Route::get('/items', [ItemController::class, 'index'])->name('item.index');
    Route::post('/items', [ItemController::class, 'store'])->name('item.store');
    Route::get('/items/detail/{param}', [ItemController::class, 'show'])->name('item.show');
    Route::put('/items/update/{param}', [ItemController::class, 'update'])->name('item.update');
    Route::delete('/items/delete/{param}', [ItemController::class, 'delete'])->name('item.delete');

    

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
