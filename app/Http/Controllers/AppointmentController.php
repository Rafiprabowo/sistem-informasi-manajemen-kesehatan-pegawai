<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('content.appointment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('content.appointment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    DB::transaction(function () use ($isAvailable, $validated){
        Appointment::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'employee_id' => auth()->user()->id,
            'doctor_id' => $validated['doctor_id'],
            'appointment_time' => $validated['appointment_time'],
        ]);

        Schedule::where('available_time',$validated['appointment_time'])->update([
            'is_available' => false
        ]);

    });

    return redirect()->back()->with('success', 'Data berhasil ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
