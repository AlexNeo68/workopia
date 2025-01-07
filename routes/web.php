<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/jobs', function () {
    return '<h1>This is my jobs</h1>';
})->name('jobs');

Route::match(['get', 'post'], '/submit', function () {
    return 'was submitted';
});

Route::get('/test', function () {
    $url = route('jobs');
    return "<a href='$url'>Click here</a>";
});


Route::get('/api/users/1', fn() => [
    'login' => 'alexneo68',
    'email' => 'info@makewww.ru'
]);
