<?php

namespace App\Http\Controllers;

use App\Events\newAppointment;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\DoctorSpecialization;
use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AppointmentsControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $user = Auth::user()->load('employee');
        $specializations = DoctorSpecialization::all();
        $doctors = Doctor::with('user')->get();
        return view('content.appointment.pegawai.create_appointment' , compact('doctors', 'user', 'specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'employee_id' => 'required|exists:employees,id',
        'doctor_id' => 'required|exists:doctors,id',
        'schedule_id' => 'required|exists:doctor_schedules,id',
        'appointment_type' => 'required',
        'note' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()], 422);
    }

    $validated = $validator->validated();

    try {
        DB::transaction(function () use ($validated) {
            $schedule = DoctorSchedule::findOrFail($validated['schedule_id']);
            $appointment = Appointment::create([
                'employee_id' => $validated['employee_id'],
                'doctor_id' => $validated['doctor_id'],
                'appointment_date' => $schedule->date,
                'appointment_start_time' => $schedule->start_time,
                'appointment_end_time' => $schedule->end_time,
                'appointment_type' => $validated['appointment_type'],
                'note' => $validated['note'],
            ]);

            $schedule->update([
                'status' => 'reserved',
                'employee_id' => $validated['employee_id'],
            ]);

            event(new newAppointment($appointment));
        });

        return response()->json(['status' => 'success', 'message' => 'Appointment created successfully.']);
    } catch (\Exception $exception) {
        return response()->json(['status' => 'error', 'message' => $exception->getMessage()]);
    }
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
