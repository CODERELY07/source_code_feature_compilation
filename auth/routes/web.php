<?php

use App\Http\Controllers\LoginGithub;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialLoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('guest')->group(function () {
    // Github And Google
    Route::get('/socialite/{driver}', [SocialLoginController::class,'toProvider'])->where('driver', 'github|google');
    Route::get('/auth/{driver}/login', [SocialLoginController::class,'handleCallback'])->where('driver', 'github|google');
});

require __DIR__.'/auth.php';
