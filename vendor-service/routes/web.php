<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;

// 1. THE Hub Redirection FIX: Place this at the very top of your file
Route::get('/login', function () {
    // Redirects the vendor browser node back to your Auth Service application
    return redirect('http://127.0.0.1:8888/login'); 
})->name('login');

Route::middleware(['auth', 'role:vendor'])->group(function () {
    // 1. Main Dashboard View
    Route::get('/vendor/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');

    // 2. MAKE SURE THIS LINE HAS THE EXACT NAME MATCHING BELOW:
    Route::get('/vendor/users', [VendorController::class, 'userRegistry'])->name('vendor.users.index');

    // 3. Form Action Endpoints
    Route::post('/vendor/blog', [VendorController::class, 'storeBlog'])->name('vendor.blog.store');
    Route::post('/vendor/profile', [VendorController::class, 'updateProfile'])->name('vendor.profile.update');
});