<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemeriksaan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function medicalCheckUp()
    {
        return $this->belongsTo(MedicalCheckUp::class, 'id_medical_check_up');
    }

    public function pemeriksaanMinor()
    {
        return $this->belongsTo(PemeriksaanMinor::class, 'id_pemeriksaan_minor');
    }
}
