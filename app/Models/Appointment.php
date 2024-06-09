<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function employees() : BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function doctor() : BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function schedule() : BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}
