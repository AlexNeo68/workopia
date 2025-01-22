<?php

use App\Http\Controllers\AplicantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/jobs/saved', function () {
    return 'jobs saved';
})->name('jobs.saved');


Route::resource('jobs', JobController::class)->middleware('auth')->only(['create', 'update', 'edit', 'delete']);
Route::resource('jobs', JobController::class)->except(['create', 'update', 'edit', 'delete']);
Route::get('jobs-search', [JobController::class, 'search'])->name('jobs.search');

Route::resource('studios', StudioController::class)->middleware('auth')->only(['create', 'update', 'edit', 'delete']);
Route::resource('studios', StudioController::class)->except(['create', 'update', 'edit', 'delete']);
Route::get('studios-search', [StudioController::class, 'search'])->name('studios.search');


Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'form'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', [LoginController::class, 'form'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
});


Route::middleware('auth')->group(function () {
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('jobs.bookmarked');
    Route::post('/bookmarks/{job}', [BookmarkController::class, 'store'])->name('jobs.bookmarked.store');
    Route::delete('/bookmarks/{job}', [BookmarkController::class, 'destroy'])->name('jobs.bookmarked.destroy');

    Route::post('/jobs/{job}/apply', [AplicantController::class, 'store'])->name('jobs.apply');
    Route::delete('/aplicants/{aplicant}', [AplicantController::class, 'destroy'])->name('aplicant.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/logout', [LoginController::class, 'logout'])->name('logout');
});
