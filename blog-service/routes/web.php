<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogServiceController;

// Removed automatic redirect to enforce manual navigation via the Universal Header
Route::get('/login', function () {
    abort(404);
})->name('login');

// Protected channel processing blog creations
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::post('/blogs', [BlogServiceController::class, 'store'])->name('blogs.store');
});

// Admin-only blog moderation routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/admin/blogs/{id}/approve', [BlogServiceController::class, 'approve'])->name('admin.blogs.approve');
    Route::post('/admin/blogs/{id}/reject', [BlogServiceController::class, 'reject'])->name('admin.blogs.reject');
    Route::post('/admin/blogs/{id}/disable', [BlogServiceController::class, 'disable'])->name('admin.blogs.disable');
});

// Single blog view page
Route::get('/blogs/{id}', [BlogServiceController::class, 'show'])->name('blogs.show');

// Public route to view all published blogs
Route::get('/blogs', [BlogServiceController::class, 'index'])->name('blogs.index');