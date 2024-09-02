<?php

use App\Http\Controllers\Auth\LoginController;
use App\Models\Buyer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->middleware('guest');



Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// Route::get('register', [LoginController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [LoginController::class, 'register']);



// Auth::routes();
Route::get('/home/authorized-clients', [App\Http\Controllers\HomeController::class, 'getAuthorizedClients'])->name('authorized-clients');
Route::get('/home/my-clients', [App\Http\Controllers\HomeController::class, 'getClients'])->name('personal-clients');
Route::get('/home/my-tokens', [App\Http\Controllers\HomeController::class, 'getTokens'])->name('personal-tokens');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
