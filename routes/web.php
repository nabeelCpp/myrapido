<?php

use App\Http\Controllers\Admin\{Dashboard as AdminDashboard, Drivers as DriversController};
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SuperAdmin\{DashboardController as SuperAdminDashboard, RegionController, AdminController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Super Admin Routes
Route::prefix('superadmin')->as('superadmin.')->group( function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::middleware(['superadmin'])->group(function () {
        Route::get('', [SuperAdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('regions', RegionController::class);
        Route::resource('countries', CountryController::class);
        Route::resource('cities', CityController::class);
        Route::resource('states', StateController::class);
        Route::resource('admins', AdminController::class);
        Route::resource('plans', PlanController::class);
    });
});

// Admin routes
Route::prefix('admin')->as('admin.')->group( function() {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::middleware(['admin'])->group(function() {
        Route::get('', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('drivers', DriversController::class);
    });
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
