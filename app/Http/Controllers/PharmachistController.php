<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PharmachistController extends Controller
{
    //
    public function dashboard()
    {
        $user = Auth::user();
        $totalObat = Medicine::all()->count();
        $totalKategoriObat = Medicine::all()->count();
        return view('content.apoteker.dashboard', compact('totalObat', 'totalKategoriObat', 'user'));
    }

}
