<?php

namespace App\Transformers;

use App\Models\Day;
use League\Fractal\TransformerAbstract;

class DayTransformer extends TransformerAbstract
{

    public function transform(Day $day)
    {
        return [
            'id'               => $day->id,
            'day'             => $day->day
        ];
    }
}