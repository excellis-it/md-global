<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelehealthCms extends Model
{
    use HasFactory; 

    protected $fillable = [
        'symptom_title',
        'symptom_description',
        'offer_image_1',
        'offer_image_2',
        'offer_image_3',
        'specialization_title',
        'how_it_works_title',
        'how_it_works_icon_1',
        'how_it_works_icon_2',
        'how_it_works_icon_3',
        'how_it_works_icon_1_title',
        'how_it_works_icon_2_title',
        'how_it_works_icon_3_title',
    ];
}
