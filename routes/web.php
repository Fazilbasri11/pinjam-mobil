<?php

use App\Http\Controllers\mobilController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    // Route untuk logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});


//dashboard
Route::resource('pinjam', 'App\Http\Controllers\pinjamMobilController');

//mobil
Route::resource('mobil', 'App\Http\Controllers\mobilController');

//hanya bisa diakses oleh admin
//data mobil
Route::resource('dataMobil', 'App\Http\Controllers\DataMobilController');

//permintaan
Route::resource('permintaan', 'App\Http\Controllers\permintaanController');


require __DIR__ . '/auth.php';