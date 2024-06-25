<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $attributes = [
        'status' => 'pending'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_start_time' => 'datetime:H:i',
        'appointment_end_time' => 'datetime:H:i',
    ];

    public function getAppointmentDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getAppointmentStartTimeAttribute($value){
          return Carbon::parse($value)->format('H:i');
    }

    public function getAppointmentEndTimeAttribute($value){
          return Carbon::parse($value)->format('H:i');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function doctor() : BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
    public function diagnoses() : HasOne
    {
        return $this->hasOne(Diagnoses::class);
    }


}
