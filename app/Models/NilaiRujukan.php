<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiRujukan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function pemeriksaanMinor ()
    {
        return $this->hasMany(PemeriksaanMinor::class);
    }
}
