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
use App\Models\NilaiRujukan;
use App\Models\PemeriksaanMajor;
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
        $speciality1 = DoctorSpecialization::factory()->create();
        $speciality2 = DoctorSpecialization::factory()->create();
        $speciality3 = DoctorSpecialization::factory()->create();
        $speciality4 = DoctorSpecialization::factory()->create();
        $speciality5 = DoctorSpecialization::factory()->create();
        $userDokter1 = \App\Models\User::factory()->create([
             'role' => 'dokter',
         ]);
        $doctor1 = Doctor::factory()->create([
             'user_id' => $userDokter1->id,
             'speciality_id' => $speciality1->id,
         ]);

        $userDokter2 = \App\Models\User::factory()->create([
            'role' => 'dokter',
        ]);
        $doctor2 = Doctor::factory()->create([
            'user_id' => $userDokter2->id,
            'speciality_id' => $speciality2->id,
        ]);

        $userDokter3 = \App\Models\User::factory()->create([
            'role' => 'dokter',
        ]);
        $doctor3 = Doctor::factory()->create([
            'user_id' => $userDokter3->id,
            'speciality_id' => $speciality3->id,
        ]);

        $userDokter4 = \App\Models\User::factory()->create([
            'role' => 'dokter',
        ]);
        $doctor4 = Doctor::factory()->create([
            'user_id' => $userDokter4->id,
            'speciality_id' => $speciality4->id,
        ]);

        $userDokter5 = \App\Models\User::factory()->create([
            'role' => 'dokter',
        ]);
        $doctor5 = Doctor::factory()->create([
            'user_id' => $userDokter5->id,
            'speciality_id' => $speciality5->id,
        ]);




         $userPegawai1 = \App\Models\User::factory()->create([
             'role' => 'pegawai'
         ]);
         $employee1 = Employee::factory()->create([
            'user_id' => $userPegawai1->id,
        ]);

         $userPegawai2 = \App\Models\User::factory()->create([
             'role' => 'pegawai'
         ]);
         $employee2 = Employee::factory()->create([
             'user_id' => $userPegawai2->id,
         ]);
         $userPegawai3 = \App\Models\User::factory()->create([
             'role' => 'pegawai'
         ]);
         $employee3 = Employee::factory()->create([
             'user_id' => $userPegawai3->id,
         ]);
         $userPegawai4 = \App\Models\User::factory()->create([
             'role' => 'pegawai'
         ]);
         $employee4 = Employee::factory()->create([
             'user_id' => $userPegawai4->id,
         ]);
         $userPegawai5 = \App\Models\User::factory()->create([
             'role' => 'pegawai'
         ]);
         $employee5 = Employee::factory()->create([
             'user_id' => $userPegawai5->id,
         ]);

         $userAdmin = \App\Models\User::factory()->create([
             'role' => 'admin'
         ]);
         Admin::create([
             'user_id' => $userAdmin->id
         ]);

         $userApoteker = \App\Models\User::factory()->create([
            'role' => 'apoteker'
         ]);
         Pharmacist::create([
             'user_id' =>$userApoteker->id
         ]);





         $pemeriksaanMajorHematologi = PemeriksaanMajor::factory()->create([
                'name' => ' Hematologi',
         ]);

         $hemoglobin = PemeriksaanMinor::factory()->create([
             'name' => 'hemoglobin',
             'id_pemeriksaan_major' =>$pemeriksaanMajorHematologi->id
         ]);
         $hemoglobinReferenceL = NilaiRujukan::factory()->create([
             'id_pemeriksaan_minor' => $hemoglobin->id,
             'gender' => 'L',
             'reference_value' => '12 - 16',
             'satuan' => 'gram %'
         ]);
         $hemoglobinReferenceP = NilaiRujukan::factory()->create([
             'id_pemeriksaan_minor' => $hemoglobin->id,
             'gender' => 'P',
             'reference_value' => '12 - 16',
             'satuan' => 'gram %'
         ]);

         $hematocrit = PemeriksaanMinor::factory()->create([
            'name' => 'hematocrit',
             'id_pemeriksaan_major' =>$pemeriksaanMajorHematologi->id
         ]);
         $hematocritReferenceL = NilaiRujukan::factory()->create([
            'id_pemeriksaan_minor' => $hematocrit->id,
            'gender' => 'L',
            'reference_value' => '37 - 43',
             'satuan' => '%'
         ]);
         $hematocritReferenceP = NilaiRujukan::factory()->create([
             'id_pemeriksaan_minor' => $hematocrit->id,
             'gender' => 'P',
             'reference_value' => '37 - 43',
             'satuan' => '%'
         ]);

         $eritrosit  = PemeriksaanMinor::factory()->create([
             'name' => 'eritrosiit',
             'id_pemeriksaan_major' =>$pemeriksaanMajorHematologi->id
         ]);

         $eritrosiitReferenceL = NilaiRujukan::factory()->create([
             'id_pemeriksaan_minor' => $eritrosit->id,
             'gender' => 'L',
             'reference_value' => '4,2 - 5,4',
             'satuan' => 'juta mm3'
         ]);
         $eritrosiitReferenceP = NilaiRujukan::factory()->create([
             'id_pemeriksaan_minor' => $eritrosit->id,
             'gender' => 'P',
             'reference_value' => '4,2 - 5,4',
             'satuan' => 'juta mm3'
         ]);

         $lekosit  = PemeriksaanMinor::factory()->create([
             'name' => 'lekosit',
             'id_pemeriksaan_major' =>$pemeriksaanMajorHematologi->id
         ]);

         $lekositReferenceL = NilaiRujukan::factory()->create([
             'id_pemeriksaan_minor' => $lekosit->id,
             'gender' => 'L',
             'reference_value' => '4000 - 10000',
             'satuan' => 'mm3'
         ]);
         $lekositReferenceP = NilaiRujukan::factory()->create([
             'id_pemeriksaan_minor' => $lekosit->id,
             'gender' => 'P',
             'reference_value' => '4000 - 10000',
             'satuan' => 'mm3'
         ]);

         $trombosit = PemeriksaanMinor::factory()->create([
             'name' => 'trombosit',
             'id_pemeriksaan_major' =>$pemeriksaanMajorHematologi->id
         ]);

         $trombositReferenceL = NilaiRujukan::factory()->create([
             'id_pemeriksaan_minor' => $trombosit->id,
             'gender' => 'L',
             'reference_value' => '150.000 - 450.000',
             'satuan' => 'mm3'
         ]);
         $trombositReferenceP = NilaiRujukan::factory()->create([
             'id_pemeriksaan_minor' => $trombosit->id,
             'gender' => 'P',
             'reference_value' => '150.000 - 450.000',
             'satuan' => 'mm3'
         ]);

         $lajuEndapDarah = PemeriksaanMinor::factory()->create([
            'name' => 'Laju Endap Darah',
             'id_pemeriksaan_major' =>$pemeriksaanMajorHematologi->id
         ]);
         $lajuEndapDarahReferenceL = NilaiRujukan::factory()->create([
             'id_pemeriksaan_minor' => $lajuEndapDarah->id,
             'gender' => 'L',
             'reference_value' => '0 - 20',
             'satuan' => 'mm/jam'
         ]);
         $lajuEndapDarahReferenceP = NilaiRujukan::factory()->create([
             'id_pemeriksaan_minor' => $lajuEndapDarah->id,
             'gender' => 'P',
             'reference_value' => '0 - 20',
             'satuan' => 'mm/jam'
         ]);

          $medical_check_up1 = MedicalCheckUp::factory()->create([
              'id_employee' =>$employee1->id,
              'id_doctor' =>$doctor1->id,
              'date' => now()
         ]);
          DetailPemeriksaan::factory()->create([
             'id_medical_check_up' => $medical_check_up1->id,
             'id_pemeriksaan_minor' => $hemoglobin->id,
             'result' => '100'
          ]);
          DetailPemeriksaan::factory()->create([
              'id_medical_check_up' => $medical_check_up1->id,
              'id_pemeriksaan_minor' => $eritrosit->id,
              'result' => '200',
          ]);
          DetailPemeriksaan::factory()->create([
              'id_medical_check_up' => $medical_check_up1->id,
              'id_pemeriksaan_minor' => $trombosit->id,
              'result' => '300',
          ]);
          DetailPemeriksaan::factory()->create([
              'id_medical_check_up' => $medical_check_up1->id,
              'id_pemeriksaan_minor' => $lekosit->id,
              'result' => 'baik'
          ]);
          DetailPemeriksaan::factory()->create([
             'id_medical_check_up' => $medical_check_up1->id,
             'id_pemeriksaan_minor' => $hematocrit->id,
              'result' => 'normal'
          ]);





















    }
}
