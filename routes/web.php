<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicineController;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PegawaiController;
use \App\Http\Controllers\AdminController;
use App\Http\Controllers\PharmachistController;
use App\Http\Controllers\AppointmentsControllers;
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

Route::get('/', function (){return view('template');})->middleware('auth');
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
        Route::resource('/schedule', \App\Http\Controllers\ScheduleController::class);
    });

    Route::prefix('/pegawai')->group(function () {
        Route::get('/', [PegawaiController::class, 'dashboard'])->name('pegawai.dashboard');
        Route::get('/profile', [PegawaiController::class, 'profile'])->name('pegawai.profile');
        Route::post('/profile', [PegawaiController::class, 'updateProfile']);
        Route::resource('/appointment', \App\Http\Controllers\AppointmentController::class);


    });

    Route::prefix('/admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::post('/profile', [AdminController::class, 'updateProfile']);
        Route::get('/role-user', [AdminController::class, 'changeRole'])->name('admin.changeRole');
        Route::post('/role-user', [AdminController::class, 'updateRole'])->name('admin.updateRole');
    });

    Route::prefix('/apoteker')->group(function () {
        Route::get('/', [PharmachistController::class,'dashboard'])->name('apoteker.dashboard',);
        Route::resource('/obat', MedicineController::class);
        Route::resource('/kategori-obat', \App\Http\Controllers\MedicineCategoriesController::class);
    });


    Route::post('api/fetch-doctor-schedules', function (\Illuminate\Http\Request $request) {
    $doctorId = $request->input('doctor_id');
    $now = \Carbon\Carbon::now('Asia/Jakarta');
    // Fetch schedules
    $schedules = \App\Models\Schedule::where('doctor_id', $doctorId)
        ->where('available_time', '>', $now) // Hanya jadwal di masa depan
        ->where('is_available', true) // Jadwal yang tersedia
        ->orderBy('available_time') // Urutkan berdasarkan waktu
        ->get(['doctor_id', 'available_time']);

    return response()->json(['schedules' => $schedules]);
});

    Route::post('api/approve-appointment/{id}', function ($id) {
        $appointment = Appointment::findOrFail($id);
        if($appointment) {
            if ($appointment->doctor_id != Auth::user()->doctor->id) {
                return response()->json(['success' => false, 'message' =>'You are not authorized to access this page.'], 403);
            }
            $appointment->status = 'approved';
            $appointment->save();
            return response()->json(['success' => 'Appointment successfully approved.']);
        }
        return response()->json(['success' => false, 'message' => 'Appointment not found.']);


    });
    Route::delete('api/delete-appointment/{id}', function ($id) {
        $appointment = Appointment::findOrFail($id);
        if ($appointment) {
            $appointment->delete();
            return response()->json(['success' => true, 'message' => 'Appointment deleted.']);
        }
        return response()->json(['success' => false, 'message' => 'Appointment not found.']);
    });
});




