<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medicine extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsTo(MedicineCategories::class);
    }
    public function diagnoses()
    {
        return $this->belongsToMany(Diagnoses::class, 'detail_diagnosas', 'id_medicine', 'id_diagnosis')
                    ->withTimestamps();
    }
}
