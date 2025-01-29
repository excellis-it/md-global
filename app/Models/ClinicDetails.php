<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicDetails extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function clinicOpeningDays()
    {
        return $this->hasMany(ClinicOpeningDay::class, 'clinic_details_id', 'id');
    }

    public function slots()
    {
        return $this->hasMany(Slot::class, 'clinic_detail_id', 'id');
    }

    public function clinic_slots()
    {
        return $this->hasMany(Slot::class, 'clinic_detail_id', 'id')->orderBy('slot_date', 'asc');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'clinic_details', 'id', 'user_id');
    }
}
