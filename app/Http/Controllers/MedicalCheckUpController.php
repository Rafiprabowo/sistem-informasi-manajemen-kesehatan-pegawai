<?php

namespace App\Http\Controllers;

use App\Models\DetailPemeriksaan;
use App\Models\Employee;
use App\Models\MedicalCheckUp;
use App\Models\PemeriksaanMinor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MedicalCheckUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $pemeriksaanMinors = PemeriksaanMinor::all();
        return view('content.dokter.medical-check-up.create', compact('pemeriksaanMinors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
    public function indexMedicalRecord()
    {
        $medicalCheckUps = MedicalCheckUp::with('pemeriksaanMinors')->get();
        return view('content.dokter.medical-check-up.update', compact('medicalCheckUps'));
    }

   public function submitAllPemeriksaan(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'id_employee' => 'required|exists:employees,id',
        'id_doctor' => 'required|exists:doctors,id',
        'pemeriksaanData' => 'required|array|min:1',
        'pemeriksaanData.*.id' => 'required|exists:pemeriksaan_minors,id',
        'pemeriksaanData.*.nilai' => 'required|string' // Adjust based on your validation requirements
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    // Remove duplicate pemeriksaan minor IDs
    $uniquePemeriksaanData = collect($request->pemeriksaanData)->unique('id');

    // Start a transaction to ensure atomicity
    DB::beginTransaction();
    try {
        // Create a new medical check-up record
        $medicalCheckUp = MedicalCheckUp::create([
            'id_employee' => $request->id_employee,
            'id_doctor' => $request->id_doctor,
            'date' => now() // Use the current date or provide a date field in the request
        ]);

        // Insert each pemeriksaan minor into detail_pemeriksaans
        foreach ($uniquePemeriksaanData as $pemeriksaan) {
            DetailPemeriksaan::create([
                'id_medical_check_up' => $medicalCheckUp->id,
                'id_pemeriksaan_minor' => $pemeriksaan['id'],
                'result' => $pemeriksaan['nilai'] // Use the corresponding result
            ]);
        }

        // Commit the transaction
        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Data submitted successfully'
        ]);
    } catch (\Exception $e) {
        // Rollback the transaction in case of error
        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to submit data',
            'error' => $e->getMessage()
        ], 500);
    }
}



}
