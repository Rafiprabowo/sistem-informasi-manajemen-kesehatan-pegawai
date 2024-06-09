<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PegawaiController;
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
Route::get('/', function (){return view('template');});
Route::get('/login', function() {
    return view('content.authentication.login');
});
Route::get('/register', function() {
    return view('content.authentication.register');
});
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::prefix('/dokter')->group(function () {
    Route::controller(DoctorController::class)->group(function () {
        Route::get('/', 'dashboard')->name('doctor.dashboard');
        Route::get('/profile', 'profile')->name('doctor.profile');
    });
    Route::post('/profile', [DoctorController::class, 'updateProfile']);
});

Route::prefix('/pegawai')->group(function () {
    Route::controller(PegawaiController::class)->group(function () {
        Route::get('/', 'dashboard')->name('pegawai.dashboard');
        Route::get('/profile', 'profile')->name('pegawai.profile');
        Route::post('/profile', [PegawaiController::class, 'updateProfile']);
        Route::get('/janji-temu', [PegawaiController::class, 'createJanjiTemu']);
        Route::post('/janji-temu', [PegawaiController::class, 'storeJanjiTemu']);
    });
});



