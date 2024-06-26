<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_check_ups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_employee');
            $table->foreign('id_employee')->references('id')->on('employees');
            $table->unsignedBigInteger('id_doctor');
            $table->foreign('id_doctor')->references('id')->on('doctors');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_check_ups');
    }
};
