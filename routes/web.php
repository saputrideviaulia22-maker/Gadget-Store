<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

// Halaman setelah login
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('products', ProductController::class)
        ->only(['index']);

    Route::resource('categories', CategoryController::class)
        ->only(['index']);

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Khusus admin
Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('categories', CategoryController::class)
        ->except(['index']);

    Route::resource('products', ProductController::class)
        ->except(['index']);

    // Laporan Inventaris
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');
});

require __DIR__.'/auth.php';