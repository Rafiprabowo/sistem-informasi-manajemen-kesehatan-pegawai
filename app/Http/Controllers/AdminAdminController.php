<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $admins = Admin::with('user')->paginate(5);
        return view('content.admin.admin.index',compact('admins'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('content.admin.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
            'role' => 'admin',
        ]);

        $admin = Admin::create([
            'user_id' => $user->id,
            'gender' => $request->get('gender'),
        ]);

        return redirect()->route('admins.index')->with('success', 'Admin created successfully.');
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
        $admin = Admin::with('user')->findOrFail($id);
        return view('content.admin.admin.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'date_of_birth' => 'required|date',
        'gender' => 'required|in:L,P',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'medical_history' => 'nullable|string',
        'emergency_contact_name' => 'required|string|max:255',
        'emergency_contact_number' => 'required|string|max:15',
        'emergency_contact_relationship' => 'required|string|max:255',
        'emergency_contact_address' => 'required|string|max:255',
    ]);

    // Cari user berdasarkan ID
    $user = User::findOrFail($id);

    // Perbarui data user
    $user->update([
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'address' => $request->input('address'),
        'phone' => $request->input('phone'),
    ]);

    // Cari employee yang terkait dengan user
    $employee = Employee::where('user_id', $user->id)->firstOrFail();

    // Perbarui data employee
    $employee->update([
        'position' => $request->input('position'),
        'date_of_birth' => $request->input('date_of_birth'),
        'gender' => $request->input('gender'),
        'medical_history' => $request->input('medical_history'),
        'emergency_contact_name' => $request->input('emergency_contact_name'),
        'emergency_contact_number' => $request->input('emergency_contact_number'),
        'emergency_contact_relationship' => $request->input('emergency_contact_relationship'),
        'emergency_contact_address' => $request->input('emergency_contact_address'),
    ]);

    return redirect()->route('pegawais.index')->with('success', 'Employee updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $admin = Admin::find($id);
        $admin->user->delete();
        $admin->delete();
        return redirect()->route('admins.index')->with('success', 'Admin deleted successfully.');
    }
}
