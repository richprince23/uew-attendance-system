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

// Configure schedule session
// Route::get('/')


// Start live attendance session
Route::get('/session', [SessionController::class, 'start_session'])->name('start-session');
// set configuarions for attendance session
Route::post('/start-session', [SessionController::class, 'configSession'])->name('config-session');
// invalidate session config
Route::post('/clear-session', [SessionController::class, 'clearSession'])->name('clear.session');
// Recognize from backend
Route::post('/recognize', [SessionController::class, 'recognize'])->name('recognize');
