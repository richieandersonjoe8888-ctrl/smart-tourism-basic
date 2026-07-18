<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogServiceController;

// Removed automatic redirect to enforce manual navigation via the Universal Header
Route::get('/login', function () {
    abort(404);
})->name('login');

// Protected channel processing blog creations
Route::middleware(['auth'])->group(function () {
    Route::post('/api/blogs/store', [BlogServiceController::class, 'store'])->name('blog.service.store');
});

// Public route to view all published blogs
Route::get('/blogs', [BlogServiceController::class, 'index'])->name('blogs.index');