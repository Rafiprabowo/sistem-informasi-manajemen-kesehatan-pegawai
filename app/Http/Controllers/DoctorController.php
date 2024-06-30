<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSpecialization;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    //
    public function dashboard(){
       // Ambil pengguna yang sedang login
        $user = Auth::user()->load(['doctor.appointments', 'doctor.medicalCheckups', 'doctor.schedules']);

        // Notifikasi
        $notifications = $user->notifications;
        $unreadNotifications = $user->unreadNotifications;

        // Hitung total appointments yang belum didiagnosis
        $totalAppointmentsBelumDidiagnosa = $user->doctor->appointments->where('diagnosed', false)->count();
        $totalAppointmentsPending = $user->doctor->appointments->where('status', 'pending')->count();

        // Hitung total medical checkups
        $totalMedicalCheckups = $user->doctor->medicalCheckups->count();

        // Hitung jadwal yang tersedia dan terpesan
        $schedulesAvailable = $user->doctor->schedules->where('status', 'available')->count();
        $schedulesReserved = $user->doctor->schedules->where('is_reserved', 'reserved')->count();

        // Kirim data ke view
        return view('content.dokter.dashboard', compact(
            'user',
            'notifications',
            'unreadNotifications',
            'totalAppointmentsBelumDidiagnosa',
            'totalAppointmentsPending',
            'totalMedicalCheckups',
            'schedulesAvailable',
            'schedulesReserved'
        ));

    }
    public function profile()
    {
        $user = Auth::user();
        $specializations = DoctorSpecialization::all();
        return view('content.dokter.profile', compact('user','specializations' ));
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'speciality_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = Auth::user();
        Doctor::where('user_id', $user->id)->update([
           'speciality_id' => $validator->validated()['speciality_id'],
        ]);
        return redirect()->back()->with(['success' => 'Profile updated successfully']);

    }

    public function myAppointment(){
        $user = Auth::user()->load('doctor');
        $user->load(['doctor.appointments' => function ($query) {
                    $query->with('employee.user');
                }]);
        return view('content.appointment.dokter.appointment_history', compact('user'));
    }



}
