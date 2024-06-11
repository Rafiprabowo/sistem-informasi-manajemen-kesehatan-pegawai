<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    //
    public function dashboard(){
        return view('content.dokter.dashboard');
    }
    public function profile()
    {

        return view('content.dokter.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'spesialisasi' => 'required',
        ]);

        DB::transaction(function () use ($user, $request) {
            // Update user data
            $user->name = $request->get('name');
            $user->address = $request->get('address');
            $user->phone = $request->get('phone');
            $user->save();

            // Update or create doctor data
            Doctor::updateOrCreate(
                ['user_id' => $user->id],
                ['spesialisasi' => $request->get('spesialisasi')]
            );
        });
        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function createJadwal(){
        return view('content.dokter.create_jadwal');
    }

    public function storeJadwal(Request $request)
{
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



}
