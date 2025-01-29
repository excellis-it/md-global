<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicOpeningDay extends Model
{
    use HasFactory;

    public function day()
    {
        return $this->belongsTo(Day::class, 'day_id', 'id');
    }
}
