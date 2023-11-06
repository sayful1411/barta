<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication Route
Route::get("login", [LoginController::class,"loginPage"])->name("login");
Route::post("login", [LoginController::class,"login"])->name('login.submit');
Route::get("register", [RegisterController::class,"registerPage"])->name("register");
Route::post("register", [RegisterController::class,"register"])->name('register.submit');
Route::get("logout", [LogoutController::class,"logout"])->name('logout');

// User Route
Route::middleware(['web','auth'])->group(function(){
    Route::get('/', [UserController::class,'indexPage'])->name('index');
    Route::get('profile', [UserController::class,'profilePage'])->name('profile');
    Route::get('edit-profile', [UserController::class,'profileEditPage'])->name('profile.edit');
    Route::post('edit-profile', [UserController::class,'editProfile'])->name('profile.edit.submit');
    Route::get('setting', [UserController::class,'profileSettingPage'])->name('profile.setting');
    Route::post('setting', [UserController::class,'profileSetting'])->name('profile.setting.submit');
});

