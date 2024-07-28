<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');


Route::post('/get-encodings', [App\Http\Controllers\StudentController::class, 'getEncodings'])->name('getEncodings');

// Start live attendance session
Route::get('/session', [SessionController::class, 'start_session'])->name('start-session');

// Recognize from backend
Route::post('/recognize', [SessionController::class, 'recognize'])->name('recognize');
