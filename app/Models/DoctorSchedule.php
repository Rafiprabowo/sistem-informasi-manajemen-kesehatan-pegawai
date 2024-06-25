<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function getDateAttribute($value){
        return Carbon::parse($value)->format('d-m-Y');
    }
    public function getStartTimeAttribute($value){
        return Carbon::parse($value)->format('H:i');
    }

    public function getEndTimeAttribute($value){
        return Carbon::parse($value)->format('H:i');
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }


}
