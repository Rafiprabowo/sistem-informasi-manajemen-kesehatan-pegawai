<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\MedicalCheckUpController;
use App\Http\Controllers\MedicineController;
use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Medicine;
use App\Models\MedicineCategories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PegawaiController;
use \App\Http\Controllers\AdminController;
use App\Http\Controllers\PharmachistController;
use App\Http\Controllers\AppointmentsControllers;
use App\Http\Controllers\PemeriksaanMinorController;
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

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'attemptRegister'])->name('attempt.register');
    Route::post('/login', [AuthController::class, 'attemptLogin'])->name('attempt.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('attempt.logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/notifications/mark-as-read/{id}', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    Route::prefix('/dokter')->group(function () {
        Route::get('/', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
        Route::get('/profile', [DoctorController::class, 'profile'])->name('doctor.profile');
        Route::post('/profile', [DoctorController::class, 'updateProfile'])->name('profile.update');
        Route::resource('/schedule', \App\Http\Controllers\ScheduleController::class);
        Route::resource('/appointment', AppointmentsControllers::class);
        Route::get('/appointment/{id}/create-diagnose', [\App\Http\Controllers\DiagnosesController::class, 'createDiagnose'])->name('diagnose.create');
        Route::post('/appointment/{id}/diagnose', [\App\Http\Controllers\DiagnosesController::class, 'storeDiagnose'])->name('diagnose.store');
        Route::resource('/doctor-schedules', DoctorScheduleController::class);
        Route::get('/my-appointment', [DoctorController::class, 'myAppointment'])->name('doctor.myAppointment');
        Route::resource('/medical-check-up', MedicalCheckUpController::class);
        Route::get('/medical-record', [MedicalCheckUpController::class, 'indexMedicalRecord'])->name('medical-record.index');
        });

    Route::prefix('/pegawai')->group(function () {
        Route::get('/', [PegawaiController::class, 'dashboard'])->name('pegawaiDashboard');
        Route::get('/profile', [PegawaiController::class, 'profile'])->name('profilePegawai');
        Route::post('/profile', [PegawaiController::class, 'updateProfileEmployee'])->name('updateProfileEmployee');
        Route::resource('/appointment', AppointmentsControllers::class);
        Route::get('/my-appointment', [PegawaiController::class, 'myAppointment'])->name('pegawai.myAppointment');
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

    /**
     * Api Fetch Employee
     * /api/fetch-get-all-employee
     * /api/fetch-employee/{id}
     */
    Route::get('/api/fetch-get-all-employee',function (){
        $employees = Employee::all()->load('user');
        $formattedEmployees = $employees->map(function($employee){
           return [
             'id' => $employee->id,
             'name' => $employee->user->first_name.' '.$employee->user->last_name,
             'address' => $employee->user->address,
             'phone' => $employee->user->phone,
             'position' => $employee->position,
             'gender' => $employee->gender,
             'age' => $employee->age
           ];
        });
        return response()->json(['success' => true, 'data' => $formattedEmployees]);
    })->name('fetch-all-employee');
    Route::get('/api/fetch-employee/{id}', function ($id) {
        // Find the employee
        $employee = Employee::find($id);

        // Check if employee exists
        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
        }

        // Load the 'user' relationship
        $employee->load('user');

        // Format the employee data
        $formattedEmployee = [
            'id' => $employee->id,
            'name' => $employee->user->first_name . ' ' . $employee->user->last_name,
            'address' => $employee->user->address,
            'phone' => $employee->user->phone,
            'position' => $employee->position,
            'gender' => $employee->gender,
            'age' => $employee->age
        ];

        // Return the formatted data as a JSON response
        return response()->json(['success' => true, 'data' => $formattedEmployee]);
    })->name('fetch-employee-by-id');

    /**
     * Api Fetch Doctor, Specialization and Schedule
     * api/fetch-specialization-doctor
     * api/fetch-doctor-schedule
     * api/fetch-doctor-schedules
     */
    Route::post('api/fetch-specialization-doctor', [\App\Http\Controllers\DoctorSpecializationController::class, 'fetchSpecializationsWithDoctor'])->name('fetchSpecializationsWithDoctor');
    Route::post('api/fetch-doctor-schedule', [\App\Http\Controllers\DoctorScheduleController::class, 'fetchDoctorSchedule'])->name('fetchDoctorSchedule');
    Route::post('api/fetch-doctor-schedules', function (\Illuminate\Http\Request $request) {
        $doctorId = $request->input('doctor_id');
        $now = \Carbon\Carbon::now();
        // Fetch schedules
        $schedules = \App\Models\DoctorSchedule::class::where('doctor_id', $doctorId)
            ->where('is_available', true) // Jadwal yang tersedia
                ->where('available_time', '>=', $now)
            ->get(['doctor_id', 'available_time']);
        return response()->json(['schedules' => $schedules]);
    });

    /**
     * Api Fetch Pemeriksaan
     * /api/fetch-pemeriksaan-minor/{id}
     * api/submit-all-pemeriksaan
     */

    Route::get('/api/fetch-pemeriksaan-minor/{id}', [PemeriksaanMinorController::class, 'getPemeriksaanMinorById'])->name('fetch-pemeriksaan-minor-by-id');
    Route::post('api/submit-all-pemeriksaan', [MedicalCheckUpController::class, 'submitAllPemeriksaan']);



    Route::get('api/approve-appointment/{id}', function ($id) {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'approved';
        $appointment->save();
        return response()->json(['success' => 'Appointment successfully approved.']);
    })->name('approve-appointment');
    Route::delete('api/delete-appointment/{id}', function ($id) {
        $appointment = Appointment::findOrFail($id);
        if ($appointment) {
            $appointment->delete();
            return response()->json(['success' => true, 'message' => 'Appointment deleted.']);
        }
        return response()->json(['success' => false, 'message' => 'Appointment not found.']);
    });
//    Route::get('api/cancel-appointment/{id}', function ($id) {
//        $appointment = Appointment::findOrFail($id);
//        $appointment->update([
//            'status' => 'cancelled'
//        ]);
//        $appointment->save();
//        return response()->json(['success' => true, 'message' => 'Appointment cancelled.']);
//    })->name('cancel-appointment');
    Route::get('/api/fetch-medicine-category/{id}', function ($id) {
        $medicineCategories = MedicineCategories::findOrFail($id);
        if($medicineCategories) {
            return response()->json(['medicineCategories' => $medicineCategories]);
        }
        return response()->json(['medicineCategories' => null]);
    });
    Route::post('/api/update-medicine-categories', function (\Illuminate\Http\Request $request) {

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'category_id' => 'required',
            'new_name' => 'required',
            'new_description' => 'required',
        ]);

         if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        $medicineCategory = MedicineCategories::findOrFail($request->category_id);
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




