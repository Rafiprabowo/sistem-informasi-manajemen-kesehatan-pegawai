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
        $user = Auth::user();
        $notifications = $user->notifications;
        $unreadNotifications = $user->unreadNotifications;
        return view('content.dokter.dashboard', compact('user', 'notifications', 'unreadNotifications'));
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



}
