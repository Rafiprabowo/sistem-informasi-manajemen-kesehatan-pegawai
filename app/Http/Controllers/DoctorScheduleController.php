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
            ->where(function ($query) {
                $today = Carbon::today('Asia/Jakarta');
                $now = Carbon::now('Asia/Jakarta');
                $tomorrow = Carbon::today('Asia/Jakarta')->addDay();
                $dayAfterTomorrow = Carbon::today('Asia/Jakarta')->addDays(2);

                // Untuk hari ini
                $query->where(function ($subQuery) use ($today, $now) {
                    $subQuery->whereDate('date', $today)
                             ->whereTime('start_time', '>', $now->format('H:i'));
                });

                // Untuk besok dan lusa
                $query->orWhere(function ($subQuery) use ($tomorrow, $dayAfterTomorrow) {
                    $subQuery->whereDate('date', '>=', $tomorrow)
                             ->whereDate('date', '<=', $dayAfterTomorrow);
                });
            })
            ->orderBy('date', 'asc')
            ->get();
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
        //
        $validator = Validator::make($request->all(), [
           'doctor_id' => 'required|exists:doctors,id',
           'date' => 'required|date|after_or_equal:today',
           'start_time' => 'required|date_format:H:i',
           'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }
        DoctorSchedule::create($request->all());

        return redirect()->route('doctor-schedules.index')
            ->with('success', 'Schedule created successfully.');
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
        $validator = Validator::make($request->all(), [
           'doctor_id' => 'required|exists:doctors,id',
           'date' => 'required|date',
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
    public function fetchDoctorSchedule(Request $request){
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        $schedules = DoctorSchedule::where('doctor_id', $validator->validated()['doctor_id'])
            ->where(function ($query) {
                $today = Carbon::today('Asia/Jakarta');
                $now = Carbon::now('Asia/Jakarta');
                $tomorrow = Carbon::today('Asia/Jakarta')->addDay();
                $dayAfterTomorrow = Carbon::today('Asia/Jakarta')->addDays(2);

                // Untuk hari ini
                $query->where(function ($subQuery) use ($today, $now) {
                    $subQuery->whereDate('date', $today)
                             ->whereTime('start_time', '>', $now->format('H:i'));
                });

                // Untuk besok dan lusa
                $query->orWhere(function ($subQuery) use ($tomorrow, $dayAfterTomorrow) {
                    $subQuery->whereDate('date', '>=', $tomorrow)
                             ->whereDate('date', '<=', $dayAfterTomorrow);
                });
            })
            ->where('status', 'available')
            ->orderBy('date', 'asc')
            ->get();


        $formattedSchedules = $schedules->map(function($schedule){
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
