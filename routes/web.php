<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController as dash;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfilController;
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

Route::middleware('auth')->group(function () {

    Route::resource('task', TaskController::class);

    Route::resource('categories', CategoryController::class);

    Route::get('/profile', [ProfilController::class, 'index'])->name('profile.index');

    // 1. Jalur halaman & proses ganti password
    Route::get('/profil/password', [ProfilController::class, 'editPassword'])->name('password.edit');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('password.update');

    // 2. Jalur proses menonaktifkan/menghapus akun
    Route::delete('/profil/deactivate', [ProfilController::class, 'deactivate'])->name('profile.deactivate');
});


