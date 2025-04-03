<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// ───── Default User Redirect ─────
Route::redirect('/', '/user/home');


// ───── Admin Auth Routes ─────

// Role selection page
Route::get('/admin', [AuthController::class, 'showRoleSelect'])->name('admin.role');

// Web Master Login
Route::get('/admin/login/webmaster', [AuthController::class, 'showWebmasterLogin'])->name('login.webmaster');
Route::post('/admin/login/webmaster', [AuthController::class, 'loginWebmaster'])->name('login.webmaster.submit');

// Admin Login
Route::get('/admin/login/monitor', [AuthController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/admin/login/monitor', [AuthController::class, 'loginAdmin'])->name('login.admin.submit');

// Dashboard (shared for both roles)
Route::middleware(['auth'])->get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ───── Admin Pages ─────

Route::view('/admin/sensors', 'pages.admin.sensors')->name('admin.sensors');

Route::get('/admin/data-management', function () {
    return view('pages.admin.data-management');
})->name('admin.data-management');

Route::get('/admin/user-management', function () {
    if (auth()->user()->role !== 'webmaster') {
        return view('errors.no-access');
    }
    return view('admin.partials.user-management');
})->middleware('auth')->name('admin.user-management');




Route::get('/admin/alert-configuration', function () {
    return view('pages.admin.alert-configuration');
})->name('alert.configuration');


// ───── User Public Routes ─────

Route::get('/user/home', function () {
    return view('pages.user.home');
})->name('user.home');

Route::get('/user/about', function () {
    return view('pages.user.about');
})->name('user.about');