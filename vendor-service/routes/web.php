<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;

// Removed automatic redirect to enforce manual navigation via the Universal Header
Route::get('/login', function () {
    abort(404); 
})->name('login');

Route::middleware(['auth', 'role:vendor'])->group(function () {
    // 1. Main Dashboard View
    Route::get('/vendor/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');

    // 2. MAKE SURE THIS LINE HAS THE EXACT NAME MATCHING BELOW:
    Route::get('/vendor/users', [VendorController::class, 'userRegistry'])->name('vendor.users.index');
    Route::get('/vendor/users/{id}', [VendorController::class, 'showUser'])->name('vendor.users.show');

    // 3. Form Action Endpoints
    Route::post('/vendor/blog', [VendorController::class, 'storeBlog'])->name('vendor.blog.store');
    Route::post('/vendor/profile', [VendorController::class, 'updateProfile'])->name('vendor.profile.update');
});