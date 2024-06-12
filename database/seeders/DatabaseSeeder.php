<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\Medicine;
use App\Models\MedicineCategories;
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
         $userAdmin = \App\Models\User::factory()->create([
             'role' => 'admin'
         ]);

         Admin::create([
             'user_id' => $userAdmin->id
         ]);

         $userPegawai = \App\Models\User::factory()->create([
             'role' => 'pegawai'
         ]);

         Employee::create([
             'user_id' => $userPegawai->id
         ]);

         $userDokter = \App\Models\User::factory()->create([
             'role' => 'dokter',
         ]);

         Doctor::create([
             'user_id' => $userDokter->id
         ]);

         $userApoteker = \App\Models\User::factory()->create([
            'role' => 'apoteker'
         ]);

         Pharmacist::create([
             'user_id' =>$userApoteker->id
         ]);







    }
}
