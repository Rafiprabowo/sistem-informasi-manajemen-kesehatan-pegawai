<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicineCategories extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function medicine():HasMany
    {
        return $this->hasMany(Medicine::class);
    }
}
