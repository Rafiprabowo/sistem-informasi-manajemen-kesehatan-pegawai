<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\DetailPemeriksaan;
use App\Models\Doctor;
use App\Models\DoctorSpecialization;
use App\Models\Employee;
use App\Models\MedicalCheckUp;
use App\Models\Medicine;
use App\Models\MedicineCategories;
use App\Models\PemeriksaanMinor;
use App\Models\Pharmacist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DoctorSpecialization::factory()->count(5)->create();


         $userAdmin = \App\Models\User::factory()->create([
             'role' => 'admin'
         ]);

         Admin::create([
             'user_id' => $userAdmin->id
         ]);

         $userPegawai = \App\Models\User::factory()->create([
             'role' => 'pegawai'
         ]);

         $employee = Employee::create([
             'user_id' => $userPegawai->id
         ]);

         $userDokter = \App\Models\User::factory()->create([
             'role' => 'dokter',
         ]);

         $doctor = Doctor::create([
             'user_id' => $userDokter->id
         ]);

         $userApoteker = \App\Models\User::factory()->create([
            'role' => 'apoteker'
         ]);
         Pharmacist::create([
             'user_id' =>$userApoteker->id
         ]);

         $hemoglobin = PemeriksaanMinor::factory()->create([
            'name' => 'hemoglobin',
         ]);
         $hematocrit = PemeriksaanMinor::factory()->create([
            'name' => 'hematocrit',
         ]);
         $eritrosit  = PemeriksaanMinor::factory()->create([
             'name' => 'eritrosiit',
         ]);
         $lekosit  = PemeriksaanMinor::factory()->create([
             'name' => 'lekosiit',
         ]);
         $trombosit = PemeriksaanMinor::factory()->create([
             'name' => 'trombosit',
         ]);
         $analyzer = PemeriksaanMinor::factory()->create([
            'name' => 'analyzer',
         ]);

         $medical_check_up = MedicalCheckUp::factory()->create([
              'id_employee' =>$employee->id,
              'id_doctor' =>$doctor->id,
              'date' => now()
         ]);

          DetailPemeriksaan::factory()->create([
             'id_medical_check_up' => $medical_check_up->id,
             'id_pemeriksaan_minor' => $hemoglobin->id,
             'result' => '100'
          ]);
          DetailPemeriksaan::factory()->create([
              'id_medical_check_up' => $medical_check_up->id,
              'id_pemeriksaan_minor' => $eritrosit->id,
              'result' => '200',
          ]);
          DetailPemeriksaan::factory()->create([
              'id_medical_check_up' => $medical_check_up->id,
              'id_pemeriksaan_minor' => $trombosit->id,
              'result' => '300',
          ]);



















    }
}
