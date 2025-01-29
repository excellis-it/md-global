<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanSpecfication extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'specification_name',
    ];
    
    public function Plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
