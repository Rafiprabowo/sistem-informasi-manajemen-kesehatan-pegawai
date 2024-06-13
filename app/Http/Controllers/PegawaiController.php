<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    //

    public function dashboard(){
        return view('content.pegawai.dashboard');
    }
    public function profile(){
        return view('content.pegawai.profile');
    }
    public function updateProfile(Request $request){
        $user = Auth::user();

    $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'address' => 'required',
    ]);

        DB::transaction(function () use ($user, $request) {
        // Update user data
        $user->name = $request->get('name');
        $user->address = $request->get('address');
        $user->phone = $request->get('phone');
        $user->save();

        // Update or create doctor data
        Employee::updateOrCreate(
            ['user_id' => $user->id]
        );

        });
        return redirect()->back()->with('success', 'Profile updated successfully');
    }

public function showAppointments()
{
    $user = Auth::user();

    // Pastikan employee ter-load dan memiliki appointments
    $employee = Employee::with('appointments')->where('user_id', $user->id)->firstOrFail();

    return view('content.appointment.pegawai.appointment_history', compact('employee'));
}


    public function createAppointment(){
        return view('content.appointment.pegawai.create_appointment');
    }
    public function storeAppointment(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'doctor_id' => 'required|exists:doctors,id',
        'appointment_time' => 'required|date|after:now',
    ]);

    try {
        DB::transaction(function () use ($validatedData) {
            // Buat janji temu baru
            $appointment = Appointment::create([
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'employee_id' => Auth::user()->employee->id,
                'doctor_id' => $validatedData['doctor_id'],
                'appointment_time' => $validatedData['appointment_time'],
            ]);

            // Update jadwal ketersediaan
            Schedule::where('doctor_id', $validatedData['doctor_id'])
                ->where('available_time', $validatedData['appointment_time'])
                ->update(['is_available' => false]);
        });

        return redirect()->back()->with('success', 'Data berhasil ditambah.');
    } catch (\Exception $exception) {
        // Jika terjadi kesalahan, rollback transaksi dan tampilkan pesan kesalahan
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $exception->getMessage()]);
    }
}


}
