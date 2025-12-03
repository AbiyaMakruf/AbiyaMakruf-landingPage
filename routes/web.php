<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminSubdomainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/subdomain/{subdomain:slug}', [PublicController::class, 'show'])->name('subdomain.show');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminSubdomainController::class, 'index'])->name('dashboard');
    Route::get('/create', [AdminSubdomainController::class, 'create'])->name('create');
    Route::post('/store', [AdminSubdomainController::class, 'store'])->name('store');
    Route::get('/edit/{subdomain}', [AdminSubdomainController::class, 'edit'])->name('edit');
    Route::put('/update/{subdomain}', [AdminSubdomainController::class, 'update'])->name('update');
    Route::delete('/delete/{subdomain}', [AdminSubdomainController::class, 'destroy'])->name('destroy');
    Route::delete('/image/{image}', [AdminSubdomainController::class, 'deleteImage'])->name('image.delete');
});
