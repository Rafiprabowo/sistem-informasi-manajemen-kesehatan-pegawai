<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnoses extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'detail_diagnosas', 'id_diagnosis', 'id_medicine')
                    ->withTimestamps();
    }
}
