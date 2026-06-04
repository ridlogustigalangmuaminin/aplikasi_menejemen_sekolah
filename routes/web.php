<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController as dash;
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

Route::get('/', function () {
    return view('welcome');
});

// REGISTER
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// LOGIN
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'store']);

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman Dashboard Setelah Sukses Login (Contoh)
Route::get('/dashboard', [dash::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('/task', function () {
    return view('task.index');
})->name('task.index')->middleware('auth');

Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index')->middleware('auth');
