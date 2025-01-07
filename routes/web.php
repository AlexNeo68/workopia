<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/jobs/saved', function () {
    return 'jobs saved';
})->name('jobs.saved');
Route::resource('jobs', JobController::class);
