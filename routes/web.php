<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/jobs/saved', function () {
    return 'jobs saved';
})->name('jobs.saved');


Route::resource('jobs', JobController::class)->middleware('auth')->only(['create', 'update', 'edit', 'delete']);
Route::resource('jobs', JobController::class)->except(['create', 'update', 'edit', 'delete']);


Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'form'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', [LoginController::class, 'form'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/logout', [LoginController::class, 'logout'])->name('logout');
});
