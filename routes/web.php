<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;

Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('/', [HomeController::class, 'indexPage'])->name('index');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/update-profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/delete-profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users/{username}', [UserController::class, 'index'])->name('users.profile');

    Route::resource('/posts', PostController::class)->except(['create']);

    Route::resource('posts.comments', CommentController::class)->except(['create', 'show']);

    Route::get('/users', SearchController::class)->name('search.user');

    Route::get('/notifications', [NotificationController::class, 'showAllNotification'])->name('notifications');
});

require __DIR__.'/auth.php';
