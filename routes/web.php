<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Web TaskFlow
|--------------------------------------------------------------------------
| Seluruh rute aplikasi TaskFlow disajikan dalam Bahasa Indonesia.
|
*/

// Halaman Beranda (Landing Page)
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Rute Tamu (Guest - Belum Masuk)
Route::middleware('guest')->group(function () {
    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register'])->name('register.submit');

    Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk', [AuthController::class, 'login'])->name('login.submit');
});

// Rute Khusus Pengguna Masuk (Authenticated)
Route::middleware('auth')->group(function () {
    Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');

    // Manajemen Tugas Pengguna
    Route::get('/tugas', [TodoController::class, 'index'])->name('todos.index');
    Route::post('/tugas', [TodoController::class, 'store'])->name('todos.store');
    Route::patch('/tugas/{todo}', [TodoController::class, 'update'])->name('todos.update');
    Route::delete('/tugas/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');

    // Panel Admin (Khusus Administrator - Read-Only)
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/pengguna', [AdminController::class, 'index'])->name('admin.users');
    });
});
