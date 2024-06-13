<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Periksa apakah pengguna sudah terautentikasi
    if (Auth::check()) {
        $user = Auth::user();

        // Cek peran pengguna dan kembalikan view yang sesuai
        switch ($user->role) {
            case 'dokter':
                return view('content.appointment.dokter.appointment_history');
            case 'pegawai':
                return view('content.appointment.pegawai.appointment_history');
            default:
                return abort(403, 'Unauthorized action.');
        }
    }

    // Jika pengguna belum login, arahkan ke halaman login
    return redirect()->route('login');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('content.appointment.pegawai.create_appointment');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'doctor_id' => 'required|exists:doctors,id',
        'appointment_time' => 'required|date|after:now',
    ]);

    try {
        DB::transaction(function () use ($validatedData) {
            // Buat janji temu baru
            $appointment = Appointment::create([
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'employee_id' => Auth::user()->employee->id,
                'doctor_id' => $validatedData['doctor_id'],
                'appointment_time' => $validatedData['appointment_time'],
            ]);

            // Update jadwal ketersediaan
            Schedule::where('doctor_id', $validatedData['doctor_id'])
                ->where('available_time', $validatedData['appointment_time'])
                ->update(['is_available' => false]);
        });

        return redirect()->back()->with('success', 'Data berhasil ditambah.');
    } catch (\Exception $exception) {
        // Jika terjadi kesalahan, rollback transaksi dan tampilkan pesan kesalahan
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $exception->getMessage()]);
    }
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
