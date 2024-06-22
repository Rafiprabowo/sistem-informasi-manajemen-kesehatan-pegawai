<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicineController;
use App\Models\Appointment;
use App\Models\Medicine;
use App\Models\MedicineCategories;
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
        Route::resource('/appointment', \App\Http\Controllers\AppointmentController::class);
        Route::get('/appointment/{id}/create-diagnose', [\App\Http\Controllers\DiagnosesController::class, 'createDiagnose'])->name('diagnose.create');
        Route::post('/appointment/{id}/diagnose', [\App\Http\Controllers\DiagnosesController::class, 'storeDiagnose'])->name('diagnose.store');
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
        $now = \Carbon\Carbon::now();
        // Fetch schedules
        $schedules = \App\Models\Schedule::class::where('doctor_id', $doctorId)
            ->where('is_available', true) // Jadwal yang tersedia
                ->where('available_time', '>=', $now)
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

    Route::get('/api/fetch-medicine-category/{id}', function ($id) {
        $medicineCategories = MedicineCategories::findOrFail($id);
        if($medicineCategories) {
            return response()->json(['medicineCategories' => $medicineCategories]);
        }
        return response()->json(['medicineCategories' => null]);
    });

    Route::post('/api/medicine-categories', function (\Illuminate\Http\Request $request) {
        $categoryId = $request->input('category_id');
        if (!$categoryId) {
            return response()->json(['success' => false, 'message' => 'Category id is required.']);
        }
        $medicineCategory = MedicineCategories::findOrFail($categoryId);
        $medicineCategory->name = $request->input('new_name');
        $medicineCategory->description = $request->input('new_description');
        $medicineCategory->save();
        return response()->json(['success' => true, 'medicineCategory' => $medicineCategory]);
    });


    Route::get('/api/medicine/{id}', function ($id) {
        $medicine = Medicine::findOrFail($id);
        if(!$medicine){
            return response()->json(['success' => false, 'message' => 'Medicine not found.']);
        }
        return response()->json(['medicine' => $medicine]);
    });

    Route::post('/api/updateMedicine', function (\Illuminate\Http\Request $request) {
        /** @var
         * $validator = Validator::make($request->all(), [
         *  'medicine_id' => 'required',
         * 'new_name' => 'required',
         * 'new_description' => 'required',
         * 'new_category_id' => 'required'
         * ]);
         *
         * if($validator->fails()){
         *     return response()->json($validator->errors(),422);
         * }
         * Medicine::updateOrCreate(
         *     ['id' => $request->medicine_id],
         *      ['name' => $request->new_name,
         *         'description' => $request->new_description,
         *          'categories_id' => $request->new_category_id
         *      ]
         * );
         * return response()->json(['success' => true, 'message' => 'Medicine updated successfully', '')
         */
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
           'medicine_id' => 'required',
           'new_name' => 'required',
           'new_description' => 'required',
           'new_category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        $medicine = Medicine::findOrFail($request->medicine_id);
        if(!$medicine){
            return response()->json(['success' => false, 'message' => 'Medicine not found.']);
        }
        $category = MedicineCategories::findOrFail($request->new_category_id);
        if(!$category){
            return response()->json(['success' => false, 'message' => 'Medicine not found.']);
        }
        $medicine->name = $request->new_name;
        $medicine->description = $request->new_description;
        $medicine->categories_id = $category->id;
        $medicine->save();
        return response()->json(['success' => true, 'medicine' => $medicine, 'category_name' => $category->name]);
    });

    Route::post('/api/delete-medicine', function (\Illuminate\Http\Request $request) {
       $medicineId = $request->get('medicine_id');
       if (!$medicineId) {
           return response()->json(['success' => false, 'message' => 'Medicine id is required.']);
       }
       $medicine = Medicine::findOrFail($medicineId);
       if(!$medicine){
           return response()->json(['success' => false, 'message' => 'Medicine not found.']);
       }
       $medicine->delete();
       return response()->json(['success' => true, 'message' => 'Medicine deleted.']);
    });

    Route::post('/api/delete-medicine-category', function (\Illuminate\Http\Request $request) {
       $categoryId = $request->get('category_id');
       if (!$categoryId) {
           return response()->json(['success' => false, 'message' => 'Category id is required.']);
       }
       $category = MedicineCategories::findOrFail($categoryId);
       if(!$category){
           return response()->json(['success' => false, 'message' => 'Category not found.']);
       }
       $category->delete();
       return response()->json(['success' => true, 'message' => 'Category deleted.']);
    });
});




