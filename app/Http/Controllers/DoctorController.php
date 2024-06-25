<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSpecialization;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $user = Auth::user();
        $specializations = DoctorSpecialization::all();
        return view('content.dokter.profile', compact('user','specializations' ));
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'speciality_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = Auth::user();
        Doctor::where('user_id', $user->id)->update([
           'speciality_id' => $validator->validated()['speciality_id'],
        ]);
        return redirect()->back()->with(['success' => 'Profile updated successfully']);

    }



}
