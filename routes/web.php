<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PegawaiController;
use \App\Http\Controllers\AdminController;
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
        Route::get('/', 'dashboard')->name('dokter.dashboard');
        Route::get('/profile', 'profile')->name('doctor.profile');
    });
    Route::post('/profile', [DoctorController::class, 'updateProfile']);
    Route::get('/jadwal', [DoctorController::class, 'createJadwal'])->name('dokter.createJadwal');
    Route::post('/jadwal', [DoctorController::class, 'storeJadwal'])->name('dokter.storeJadwal');
});

Route::prefix('/pegawai')->group(function () {
    Route::controller(PegawaiController::class)->group(function () {
        Route::get('/', 'dashboard')->name('pegawai.dashboard');
        Route::get('/profile', 'profile')->name('pegawai.profile');
        Route::post('/profile', [PegawaiController::class, 'updateProfile']);
        Route::get('/janji-temu', [PegawaiController::class, 'createJanjiTemu']);
    });
});

Route::prefix('/admin')->group(function () {
   Route::controller(AdminController::class)->group(function () {
       Route::get('/', 'dashboard')->name('admin.dashboard');
       Route::get('/profile', 'profile')->name('admin.profile');

   });
   Route::post('/profile', [AdminController::class,'updateProfile']);
});

Route::post('api/fetch-doctor-schedules', function(\Illuminate\Http\Request $request){
   $data['schedules'] = \App\Models\Schedule::where('doctor_id', $request->get('doctor_id'))->get(['doctor_id', 'available_time']);
    return response()->json($data);
});

Route::post('api/store-janjiTemu', [\App\Http\Controllers\AppointmentsController::class, 'storeJanjiTemu']);



