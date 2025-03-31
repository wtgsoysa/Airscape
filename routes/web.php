<?php

use Illuminate\Support\Facades\Route;

// Default Route → Redirect to User Home
Route::redirect('/', '/user/home');

// ───── Admin Routes ─────

Route::view('/admin', 'pages.auth.role-selection')->name('admin.role');

Route::view('/login/webmaster', 'pages.auth.webmaster-login')->name('login.webmaster');
Route::view('/login/admin', 'pages.auth.admin-login')->name('login.admin');

Route::view('/admin/dashboard', 'pages.admin.dashboard')->name('admin.dashboard');
Route::view('/admin/sensors', 'pages.admin.sensors')->name('admin.sensors');

Route::get('/admin/data-management', function () {
    return view('pages.admin.data-management');
})->name('admin.data-management');

Route::get('/admin/user-management', function () {
    return view('pages.admin.user-management');
})->name('admin.user-management');

Route::get('/admin/alert-configuration', function () {
    return view('pages.admin.alert-configuration');
})->name('alert.configuration');

// ───── User Routes ─────

// web.php
Route::get('/user/home', function () {
    return view('pages.user.home');
})->name('user.home');

