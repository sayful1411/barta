<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('/', [HomeController::class, 'indexPage'])->name('index');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/update-profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/users/{username}', [UserController::class, 'index'])->name('users.profile');

    Route::resource('/posts', PostController::class);

    Route::resource('posts.comments', CommentController::class)->except([
        'index', 'create', 'show'
    ]);;
});

require __DIR__.'/auth.php';
