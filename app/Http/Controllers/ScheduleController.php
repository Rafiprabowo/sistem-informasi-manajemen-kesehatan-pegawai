<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('content.jadwal-dokter.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('content.jadwal-dokter.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         $validated = $request->validate([
        'doctor_id' => 'required|integer|exists:doctors,id',
        'available_time' => 'required|date_format:Y-m-d\TH:i',
    ]);

    Schedule::updateOrCreate(
        ['available_time' => $validated['available_time']],
        [
        'doctor_id' => $validated['doctor_id'],
        'available_time' => $validated['available_time'],
        'is_available' => 1,
        ]
    );

    return redirect()->back()->with('success', 'Jadwal dokter berhasil dibuat');
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
