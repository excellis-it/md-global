<?php

namespace App\Transformers;

use App\Models\Slot;
use League\Fractal\TransformerAbstract;

class PresentSheduleTransformer extends TransformerAbstract
{

    public function transform(Slot $slot)
    {
        return [
            'id'               => $slot->id,
            'slot_start_time'             => $slot->slot_start_time,
            'slot_end_time'            => $slot->slot_end_time,
            'slot_date'            => $slot->slot_date,
        ];
    }
}
