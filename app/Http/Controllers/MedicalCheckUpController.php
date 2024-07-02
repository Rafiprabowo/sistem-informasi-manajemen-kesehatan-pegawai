<?php

namespace App\Http\Controllers;

use App\Models\DetailPemeriksaan;
use App\Models\Employee;
use App\Models\MedicalCheckUp;
use App\Models\PemeriksaanMinor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
         $medicalCheckUps = MedicalCheckUp::with(['pemeriksaanMinors' => function ($query) {
            $query->with(['nilaiRujukan', 'pemeriksaanMajor']);
        }])
            ->where('id_doctor', Auth::user()->doctor->id)
            ->paginate(10);
        return view('content.dokter.medical-check-up.index', compact('medicalCheckUps'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $pemeriksaanMinors = PemeriksaanMinor::all();
        $doctorId = Auth::user()->doctor->id;

        $medicalCheckUps = MedicalCheckUp::with('employee.user')
            ->where('id_doctor', $doctorId)
            ->where('status', 0)
            ->get(); // tambahkan get() untuk mengeksekusi query

        return view('content.dokter.medical-check-up.create', compact('pemeriksaanMinors', 'medicalCheckUps'));

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
         $medicalCheckUps = MedicalCheckUp::with(['pemeriksaanMinors' => function ($query) {
            $query->with(['nilaiRujukan', 'pemeriksaanMajor']);
        }])->with('employee.user')->findOrFail($id);
         $user = Auth::user()->load('doctor');
        return view('content.dokter.medical-check-up.detail', compact('medicalCheckUps', 'user'));

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
    public function storeMcu(Request $request){
        $request->validate([
            'id_employee' => 'required|exists:employees,id',
            'id_doctor' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
        ]);

        MedicalCheckUp::create($request->all());
        return redirect()->route('jadwalCheckUpPegawai')->with('success', 'Data berhasil ditambah');
    }
    public function updateMcu(Request $request, string $id){
        $request->validate([
            'id_employee' => 'required|exists:employees,id',
            'id_doctor' => 'required|exists:doctors,id',
            'date' => 'required|date',
        ]);
        MedicalCheckUp::find($id)->update($request->all());
        return redirect()->route('jadwalCheckUpPegawai')->with('success', 'Data berhasil diubah');
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
        $medicalCheckUps = MedicalCheckUp::with(['pemeriksaanMinors' => function ($query) {
            $query->with(['nilaiRujukan', 'pemeriksaanMajor']);
        }])
            ->where('id_doctor', Auth::user()->doctor->id)
            ->get();
        return view('content.dokter.medical-check-up.update', compact('medicalCheckUps'));
    }

   public function submitAllPemeriksaan(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'id_employee' => 'required|exists:employees,id',
        'id_doctor' => 'required|exists:doctors,id',
        'medical_check_ups_id' => 'required|exists:medical_check_ups,id', // Ensure this matches your database table name
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
        // Retrieve the medical check-up record
        $medicalCheckUp = MedicalCheckUp::findOrFail($request->medical_check_ups_id);

        // Update the medical check-up record
        $medicalCheckUp->update([
            'date' => now(),
            'status' => 1,
        ]);

            foreach ($uniquePemeriksaanData as $pemeriksaan) {
            DetailPemeriksaan::updateOrCreate(
                [
                    'id_medical_check_up' => $medicalCheckUp->id,
                    'id_pemeriksaan_minor' => $pemeriksaan['id']
                ],
                [
                    'result' => $pemeriksaan['nilai']
                ]
            );
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
