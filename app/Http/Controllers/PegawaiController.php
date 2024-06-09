<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Employee;
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

    public function createJanjiTemu(){
        return view('content.pegawai.create_janji_temu');
    }
    public function storeJanjiTemu(Request $request){
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'appointments_time' => 'required',
            'employee_id' => 'required',
            'doctor_id' => 'required',
        ]);

        DB::transaction(function () use ($request) {
           Appointment::Create(
              ['name' => $request->get('name'),
                  'phone' => $request->get('phone'),
                  'address' => $request->get('address'),
                  'appointments_time' => $request->get('appointments_time'),
                  'employee_id' => $request->get('employee_id'),
                  'doctor_id' => $request->get('doctor_id'),]
           );
        });

        return redirect()->back()->with('success', 'Jadwal temu berhasil ditambahkan');
    }
}
