<?php
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::view('/admin', 'pages.auth.role-selection')->name('admin.role');

Route::get('/login/webmaster', function () {
    return 'Web Master Login Page'; // temp placeholder
})->name('login.webmaster');

Route::get('/login/admin', function () {
    return 'Admin Login Page'; // temp placeholder
})->name('login.admin');

Route::view('/login/webmaster', 'pages.auth.webmaster-login')->name('login.webmaster');
Route::view('/login/admin', 'pages.auth.admin-login')->name('login.admin');
Route::view('/admin/dashboard', 'pages.admin.dashboard')->name('admin.dashboard');
Route::view('/admin/sensors', 'pages.admin.sensors')->name('admin.sensors');

Route::get('/admin/data-management', function () {
    return view('pages.admin.data-management');
})->name('admin.data-management');


