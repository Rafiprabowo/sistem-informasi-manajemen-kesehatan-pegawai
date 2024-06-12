<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PharmachistController extends Controller
{
    //
    public function dashboard()
    {
        return view('content.apoteker.dashboard');
    }

}
