<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorApplicationController;
use App\Http\Controllers\ProfileController; // 1. IMPORT THIS CONTROLLER

// Default welcome page - aborts with 404
Route::get('/', function () {
    abort(404);
});

// Standard user dashboard home
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// User-facing Vendor Onboarding Applications
Route::middleware(['auth'])->group(function () {
    Route::get('/vendor/apply', [VendorApplicationController::class, 'showForm'])->name('vendor.apply.form');
    Route::post('/vendor/apply', [VendorApplicationController::class, 'storeApplication'])->middleware('throttle:2,1440')->name('vendor.apply.store');
});

// 2. RESTORED BREEZE USER PROFILE ROUTES (Place this group here)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Secure Administrative Console
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/panel', [AdminController::class, 'index'])->name('admin.panel');
    Route::post('/admin/applications/{application}/handle', [AdminController::class, 'handleApplicationAction'])->name('admin.application.handle');
    Route::post('/admin/user/{user}/ban', [AdminController::class, 'toggleUserBan'])->name('admin.user.ban');
    Route::post('/admin/tags', [AdminController::class, 'storeTag'])->name('admin.tags.store');
});

// Core login / register sub-files link
require __DIR__.'/auth.php';