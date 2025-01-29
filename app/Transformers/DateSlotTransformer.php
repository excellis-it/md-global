<?php

namespace App\Transformers;

use App\Helpers\Helper;
use App\Models\Slot;
use League\Fractal\TransformerAbstract;
use App\Models\User;

class DateSlotTransformer extends TransformerAbstract
{

    public function transform(Slot $slot)
    {
        return [
            'id'               => $slot->id,
            'slot_date'             => $slot->slot_date,
            'slot_available'            => Helper::slotAvailable($slot->id),
        ];
    }
}