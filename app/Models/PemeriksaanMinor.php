<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanMinor extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function pemeriksaan(){
        return $this->hasMany(DetailPemeriksaan::class , 'id_pemeriksaan_minor' , 'id');
    }
}
