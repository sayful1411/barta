<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Authentication Route
Route::get("login", [LoginController::class,"loginPage"])->name("login");
Route::post("login", [LoginController::class,"login"])->name('login.submit');
Route::get("register", [RegisterController::class,"registerPage"])->name("register");
Route::post("register", [RegisterController::class,"register"])->name('register.submit');
Route::get("logout", [LogoutController::class,"logout"])->name('logout');

// User Route
Route::middleware(['web','auth'])->group(function(){
    Route::get('/', [HomeController::class,'indexPage'])->name('index');

    Route::get('profile', [ProfileController::class,'profilePage'])->name('profile');

    Route::get('edit-profile', [ProfileController::class,'profileEditPage'])->name('profile.edit');
    Route::post('edit-profile', [ProfileController::class,'editProfile'])->name('profile.edit.submit');

    Route::get('setting', [ProfileController::class,'profileSettingPage'])->name('profile.setting');
    Route::post('setting', [ProfileController::class,'profileSetting'])->name('profile.setting.submit');

    Route::get('user/{username}', [UserController::class,'userProfilePage'])->name('user.profile');
});

