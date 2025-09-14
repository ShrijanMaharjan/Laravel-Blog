<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SoftDeleteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified', 'admin'])->name('dashboard');

Route::middleware('auth', 'admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('posts', PostController::class)->middleware('auth');

Route::post('/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');

Route::get('/deleted-posts', [SoftDeleteController::class, 'showDeletedPosts'])->middleware('auth')->name('posts.deleted');
Route::post('/posts/{id}/restore', [SoftDeleteController::class, 'restore'])->middleware('auth')->name('posts.restore');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware('auth', 'admin')->name('dashboard');



require __DIR__ . '/auth.php';
