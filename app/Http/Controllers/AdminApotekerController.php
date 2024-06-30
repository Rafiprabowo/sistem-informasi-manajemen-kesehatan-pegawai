<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminApotekerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    $pharmacists = Pharmacist::with('user')->paginate(5);
        return view('content.admin.apoteker.index', compact('pharmacists'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('content.admin.apoteker.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
            'gender' => 'required'
        ]);

        // Buat user baru
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'apoteker',
        ]);

        // Buat pharmacist baru yang berelasi dengan user
        $pharmacist = Pharmacist::create([
            'user_id' => $user->id,
            'gender' => $request->get('gender'),
        ]);

        return redirect()->route('apotekers.index')->with('success', 'Pharmacist created successfully.');
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
        $pharmacist = Pharmacist::find($id);
        $pharmacist->user->delete();
        $pharmacist->delete();
        return redirect()->route('apotekers.index')->with('success', 'Pharmacist deleted successfully.');
    }


}
