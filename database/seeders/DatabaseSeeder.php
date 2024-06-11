<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(1)->create([
             'role' => 'admin'
         ]);

         \App\Models\User::factory(1)->create([
             'role' => 'pegawai'
         ]);

         \App\Models\User::factory(1)->create([
             'role' => 'dokter'
         ]);

         \App\Models\User::factory(1)->create([
            'role' => 'admin'
         ]);



    }
}
