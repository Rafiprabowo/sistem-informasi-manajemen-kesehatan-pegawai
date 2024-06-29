<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    // Assuming the authenticated user is a doctor and has a 'doctor' relationship
    $doctorId = Auth::user()->doctor->id;

       $schedules = DoctorSchedule::where('doctor_id', $doctorId)
            ->orderBy('date', 'asc')
            ->paginate(5);
        return view('content.doctor-schedules.index', compact('schedules'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $user = Auth::user()->load('doctor');
        return view('content.doctor-schedules.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        // Custom validation rule to check unique start_time and end_time for the same doctor and date
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'start_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = DoctorSchedule::where('doctor_id', $request->doctor_id)
                        ->where('date', $request->date)
                        ->where(function ($query) use ($request) {
                            $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                                ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                                ->orWhere(function($query) use ($request) {
                                    $query->where('start_time', '<', $request->start_time)
                                          ->where('end_time', '>', $request->end_time);
                                });
                        })
                        ->exists();

                    if ($exists) {
                        $fail('The schedule overlaps with an existing one.');
                    }
                },
            ],
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // If validation passes, create a new DoctorSchedule
        DoctorSchedule::create([
            'doctor_id' => $request->doctor_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'available',
        ]);

        return redirect()->route('doctor-schedules.index')->with('success', 'Schedule added successfully');
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
        $schedule = DoctorSchedule::find($id);
        $user = Auth::user()->load('doctor');
        return view('content.doctor-schedules.edit', compact('user' , 'schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
{
    $validator = Validator::make($request->all(), [
        'doctor_id' => 'required|exists:doctors,id',
        'status' => 'required',
        'date' => 'required',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $schedule = DoctorSchedule::findOrFail($id);
    $schedule->update($request->all());

    return redirect()->route('doctor-schedules.index')
        ->with('success', 'Schedule updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $schedule = DoctorSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('doctor-schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }
    public function fetchDoctorSchedule(Request $request)
{
    $validator = Validator::make($request->all(), [
        'doctor_id' => 'required|exists:doctors,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()], 422);
    }

    $schedules = DoctorSchedule::where('doctor_id', $validator->validated()['doctor_id'])
        ->where('status', 'available')
        ->orderBy('date', 'asc')
        ->get();

    // Format schedules sesuai dengan kebutuhan
    $formattedSchedules = $schedules->map(function ($schedule) {
        return [
            'id' => $schedule->id,
            'date' => $schedule->date,
            'start_time' => $schedule->start_time,
            'end_time' => $schedule->end_time,
        ];
    });

    return response()->json(['success' => true, 'data' => $formattedSchedules], 200);
}

}
