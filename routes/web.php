<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminUserController;

// ───── Default User Redirect ─────
Route::redirect('/', '/user/home');

// ───── Admin Auth Routes ─────
Route::get('/admin', [AuthController::class, 'showRoleSelect'])->name('admin.role');
Route::get('/admin/login/webmaster', [AuthController::class, 'showWebmasterLogin'])->name('login.webmaster');
Route::post('/admin/login/webmaster', [AuthController::class, 'loginWebmaster'])->name('login.webmaster.submit');

Route::get('/admin/login/monitor', [AuthController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/admin/login/monitor', [AuthController::class, 'loginAdmin'])->name('login.admin.submit');

// ───── Admin Dashboard ─────
Route::middleware(['auth'])->get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

// ───── Logout ─────
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ───── Admin Pages (static views) ─────
Route::view('/admin/sensors', 'pages.admin.sensors')->name('admin.sensors');
Route::view('/admin/data-management', 'pages.admin.data-management')->name('admin.data-management');
Route::view('/admin/alert-configuration', 'pages.admin.alert-configuration')->name('alert.configuration');

// ✅ AdminUser Management (Web Master only)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/user-management', [AdminUserController::class, 'index'])->name('admin.user-management');
    Route::post('/admin/user-management', [AdminUserController::class, 'store'])->name('admin.user-management.store');
});

// ───── User Public Routes ─────
Route::view('/user/home', 'pages.user.home')->name('user.home');
Route::view('/user/about', 'pages.user.about')->name('user.about');
Route::view('/user/contact', 'pages.user.contact')->name('user.contact');
