<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogServiceController;

// Fallback login redirect mirror pointing back to the core hub
Route::get('/login', function () {
    return redirect('http://127.0.0.1:8888/login');
})->name('login');

// Protected channel processing blog creations
Route::middleware(['auth'])->group(function () {
    Route::post('/api/blogs/store', [BlogServiceController::class, 'store'])->name('blog.service.store');
});

// Public route to view all published blogs
Route::get('/blogs', [BlogServiceController::class, 'index'])->name('blogs.index');