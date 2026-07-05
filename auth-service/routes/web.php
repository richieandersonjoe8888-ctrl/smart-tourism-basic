<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorApplicationController;

// 1. Your original default welcome page
Route::get('/', function () {
    return view('welcome');
});

// 2. The standard user dashboard route (Breeze standard)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. User-facing Vendor Onboarding Applications
Route::middleware(['auth'])->group(function () {
    Route::get('/vendor/apply', [VendorApplicationController::class, 'showForm'])->name('vendor.apply.form');
    Route::post('/vendor/apply', [VendorApplicationController::class, 'storeApplication'])->middleware('throttle:2,1440')->name('vendor.apply.store');
});

// 4. Secure Administrative Console
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/panel', [AdminController::class, 'index'])->name('admin.panel');
    Route::post('/admin/applications/{application}/handle', [AdminController::class, 'handleApplicationAction'])->name('admin.application.handle');
    Route::post('/admin/user/{user}/ban', [AdminController::class, 'toggleUserBan'])->name('admin.user.ban');
    Route::post('/admin/tags', [AdminController::class, 'storeTag'])->name('admin.tags.store');
});

// 5. THE CRITICAL LINK: This pulls back your login/register features from yesterday!
require __DIR__.'/auth.php';