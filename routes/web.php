<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\SensorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataController; 
use App\Http\Controllers\Admin\AlertController;
use App\Http\Controllers\User\SensorDisplayController;

// ───── Default User Redirect ─────
Route::redirect('/', '/user/home');

// ───── Admin Auth Routes ─────
Route::get('/admin', [AuthController::class, 'showRoleSelect'])->name('admin.role');
Route::get('/admin/login/webmaster', [AuthController::class, 'showWebmasterLogin'])->name('login.webmaster');
Route::post('/admin/login/webmaster', [AuthController::class, 'loginWebmaster'])->name('login.webmaster.submit');
Route::get('/admin/login/monitor', [AuthController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/admin/login/monitor', [AuthController::class, 'loginAdmin'])->name('login.admin.submit');

// ───── Admin Dashboard ─────
Route::middleware(['auth'])->get('/admin/dashboard', [DashboardController::class, 'dashboardView'])->name('dashboard');

// ───── Logout ─────
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ───── Data Management ─────
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/data-management', [DataController::class, 'index'])->name('admin.data-management');
    Route::get('/admin/data-management/filter', [DataController::class, 'filter'])->name('admin.data-management.filter');
    Route::get('/admin/data-management/export', [DataController::class, 'exportCsv'])->name('admin.data-management.export');
});

// ───── Alert Configuration ─────
Route::view('/admin/alert-configuration', 'pages.admin.alert-configuration')->name('alert.configuration');

// ───── AdminUser Management ─────
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/user-management', [AdminUserController::class, 'index'])->name('admin.user-management');
    Route::post('/admin/user-management', [AdminUserController::class, 'store'])->name('admin.user-management.store');
    Route::put('/admin/user-management/{id}', [AdminUserController::class, 'update'])->name('admin.user-management.update');
    Route::delete('/admin/user-management/{id}', [AdminUserController::class, 'destroy'])->name('admin.user-management.delete');
});

// ───── Sensor Management ─────
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/sensors', [SensorController::class, 'index'])->name('admin.sensors');
    Route::post('/admin/sensors', [SensorController::class, 'store'])->name('admin.sensors.store');
    Route::delete('/admin/sensors/{id}', [SensorController::class, 'destroy'])->name('admin.sensors.delete');
    Route::get('/admin/simulate-aqi', [SensorController::class, 'simulateAQI'])->name('admin.sensors.simulate');
    Route::get('/admin/sensors/live', [SensorController::class, 'getLiveSensors'])->name('admin.sensors.live');
});

// ------- Alert ----------------
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/alert-configuration', [AlertController::class, 'index'])->name('alert.configuration');
    Route::post('/admin/alert-configuration', [AlertController::class, 'store'])->name('alert.configuration.store');
    Route::delete('/admin/alert-configuration/{id}', [AlertController::class, 'destroy'])->name('alert.configuration.delete');
    Route::delete('/admin/system-alerts/{id}', [AlertController::class, 'deleteSystemAlert'])->name('alert.system.delete');

});


// ───── User Public Routes ─────


Route::get('/user/home', [SensorDisplayController::class, 'index'])->name('user.home');

Route::view('/user/about', 'pages.user.about')->name('user.about');
Route::view('/user/contact', 'pages.user.contact')->name('user.contact');
