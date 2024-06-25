<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Diagnoses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiagnosesController extends Controller
{
    //
    public function createDiagnose($id){
        $appointment = Appointment::find($id);

        if(!$appointment){
            return redirect()->back()->with('error', 'Appointment Not Found');
        }
        $appointment->load('employee.user', 'doctor.user');
        return view('content.diagnose.create_diagnose', compact('appointment'));
    }
    public function storeDiagnose(Request $request, $id){
        $request->validate([
            'diagnose' => 'required',
        ]);
        try {
            DB::transaction(function () use($request, $id){
            Diagnoses::updateOrCreate(
                ['appointment_id' => $id],
                [
                'diagnosis' => $request->input('diagnose')
                ]);
        });
            return redirect()->back()->with('success', 'Diagnosis Successfully Created');
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }

    }
}
