<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;

/**
 * Route Login (tidak pakai middleware)
 */
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

/**
 * Route Group Admin (hanya bisa diakses jika login/admin_token ada)
 */
Route::middleware('admin.auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Tambahkan route admin lainnya di sini, misalnya:
    // Route::get('/project', [AdminProjectController::class, 'index'])->name('admin.project.index');
});
