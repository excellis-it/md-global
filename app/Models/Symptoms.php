<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptoms extends Model
{
    use HasFactory;

    protected $fillable = [
        'specialization_id',
        'symptom_name',
        'symptom_description',
        'symptom_image',
        'symptom_status',
    ];

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function getDoctorCountAttribute()
    {
        return $this->specialization->doctors()->count();
    }
}
