<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    //


    public function storeJanjiTemu(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'doctor_id' => 'required|exists:doctors,id',
        'appointment_time' => 'required|date|after:now',
    ]);

    // Periksa ketersediaan jadwal
    $isAvailable = Schedule::where('doctor_id', $validated['doctor_id'])
        ->where('available_time', $validated['appointment_time'])
        ->where('is_available', true) // Jadwal yang tersedia
        ->exists();

    if (!$isAvailable) {
        return redirect()->back()->withErrors('Jadwal yang dipilih tidak tersedia.');
    }

    // Simpan janji temu
    Appointment::create([
        'name' => $validated['name'],
        'phone' => $validated['phone'],
        'address' => $validated['address'],
        'employee_id' => auth()->user()->id,
        'doctor_id' => $validated['doctor_id'],
        'appointment_time' => $validated['appointment_time'],
    ]);

    return redirect()->back()->with('success', 'Janji temu berhasil dibuat.');
}


}
