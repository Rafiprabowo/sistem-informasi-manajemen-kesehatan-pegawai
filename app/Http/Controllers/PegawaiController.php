<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmployeeProfileRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    //

    public function dashboard(){
        return view('content.pegawai.dashboard');
    }
    public function profile(){
        $user = Auth::user()->load('employee');
        return view('content.pegawai.profile', compact('user'));
    }
     public function updateProfileEmployee(UpdateEmployeeProfileRequest $request)
    {
        $validated = $request->validated();

        try {
            $employee = DB::transaction(function () use ($validated) {
                $employee = Employee::findOrFail($validated['employee_id']);

                $employee->update([
                    'date_of_birth' => $validated['date_of_birth'],
                    'gender' => $validated['gender'],
                    'position' => $validated['position'],
                    'emergency_contact_name' => $validated['emergency_contact_name'],
                    'emergency_contact_number' => $validated['emergency_contact_number'],
                    'emergency_contact_relationship' => $validated['emergency_contact_relationship'],
                    'emergency_contact_address' => $validated['emergency_contact_address'],
                ]);
                return $employee;
            });

            $formattedEmployee = $this->formatEmployee($employee);
            return response()->json(['status' => 'success', 'data' => $formattedEmployee]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'errors' => $e->getMessage()], 500);
        }
    }

    private function formatEmployee(Employee $employee)
    {
        return [
            'employee_id' => $employee->id,
            'date_of_birth' => $employee->date_of_birth,
            'gender' => $employee->gender,
            'position' => $employee->position,
            'emergency_contact_name' => $employee->emergency_contact_name,
            'emergency_contact_number' => $employee->emergency_contact_number,
            'emergency_contact_relationship' => $employee->emergency_contact_relationship,
            'emergency_contact_address' => $employee->emergency_contact_address,
        ];
    }
    public function myAppointment()
    {
         $user = Auth::user()->load('employee');
         $user->load(['employee.appointments' => function($query) {
                        $query->with('doctor.user');
                     }]);
                     return view('content.appointment.pegawai.appointment_history', compact('user'));
    }


}
