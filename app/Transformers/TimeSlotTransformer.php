<?php

namespace App\Transformers;

use App\Helpers\Helper;
use App\Models\Slot;
use League\Fractal\TransformerAbstract;
use App\Models\User;

class TimeSlotTransformer extends TransformerAbstract
{

    public function transform($slot_times)
    {
        return [
            'slot_time'             => $slot_times['time'],
            'slot_available'            => (Helper::countSlotTimeAvailability($slot_times['clinic_id'], $slot_times['date'], $slot_times['time']) == 0) ? 'Available' : 'Not Available',
        ];
    }
}