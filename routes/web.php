<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PegawaiController;
use \App\Http\Controllers\AdminController;
use App\Http\Controllers\PharmachistController;
use App\Http\Controllers\AppointmentsController;
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
Route::get('/create-diagnosis', function (){
    return view('content.dokter.create_diagnosis');
});

Route::get('/', function (){return view('template');});
Route::get('/login', function() {
    return view('content.authentication.login');
})->name('login');

Route::get('/register', function() {
    return view('content.authentication.register');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth')->group(function () {
    Route::prefix('/dokter')->group(function () {
        Route::get('/', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
        Route::get('/profile', [DoctorController::class, 'profile'])->name('doctor.profile');
        Route::post('/profile', [DoctorController::class, 'updateProfile'])->name('doctor.update');
        Route::get('/jadwal', [DoctorController::class, 'createJadwal'])->name('jadwal.create');
        Route::post('/jadwal', [DoctorController::class, 'storeJadwal'])->name('jadwal.store');
    });

    Route::prefix('/pegawai')->group(function () {
        Route::get('/', [PegawaiController::class, 'dashboard'])->name('pegawai.dashboard');
        Route::get('/profile', [PegawaiController::class, 'profile'])->name('pegawai.profile');
        Route::post('/profile', [PegawaiController::class, 'updateProfile']);
        Route::get('/janji-temu', [PegawaiController::class, 'createJanjiTemu']);
    });

    Route::prefix('/admin')->group(function () {

        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::post('/profile', [AdminController::class, 'updateProfile']);
    });

    Route::prefix('/apoteker')->group(function () {
        Route::get('/', [PharmachistController::class,])->name('apoteker.dashboard',);
        Route::get('/obat', [PharmachistController::class, 'showMedicines'])->name('medicines.show');
        Route::get('/obat/create', [PharmachistController::class, 'createMedicine'])->name('medicine.create');
        Route::get('/kategori', [PharmachistController::class, 'showCategories'])->name('categories.show');
        Route::get('/kategori/create', [PharmachistController::class, 'createCategory'])->name('category.create');
        Route::post('/obat', [PharmachistController::class, 'storeMedicine'])->name('medicines.store');
    });


    Route::post('api/fetch-doctor-schedules', function (\Illuminate\Http\Request $request) {
        $data['schedules'] = \App\Models\Schedule::where('doctor_id', $request->get('doctor_id'))->get(['doctor_id', 'available_time']);
        return response()->json($data);
    });

    Route::post('api/store-janjiTemu', [AppointmentsController::class, 'storeJanjiTemu']);

});




