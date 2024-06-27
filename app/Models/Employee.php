<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function medicalCheckups(): HasMany{
        return $this->hasMany(MedicalCheckup::class);
    }

    // Accessor for age
    public function getAgeAttribute()
    {
        return Carbon::parse($this->date_of_birth)->age;
    }


}
