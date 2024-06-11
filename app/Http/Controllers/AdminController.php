<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function dashboard(){
        return view('content.admin.dashboard');
    }
    public function profile(){
        return view('content.admin.profile');
    }
    public function updateProfile(Request $request){
        $user = Auth::user();
        $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'address' => 'required',
        'spesialisasi' => 'required',
    ]);

        DB::transaction(function() use($user, $request){
            $user->name = $request->get('name');
        $user->address = $request->get('address');
        $user->phone = $request->get('phone');
        $user->save();

           Admin::updateOrCreate(
            ['user_id' => $user->id],

        );
        });
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
