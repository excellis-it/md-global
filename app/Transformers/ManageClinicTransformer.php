<?php

namespace App\Transformers;

use App\Models\ClinicDetails;
use League\Fractal\TransformerAbstract;
use App\Models\User;

class ManageClinicTransformer extends TransformerAbstract
{

    public function transform(ClinicDetails $clinic)
    {
        return [
            'id'               => $clinic->id,
            'clinic_name'             => $clinic->clinic_name,
            'clinic_address'            => $clinic->clinic_address,
            'clinic_phone'            => $clinic->clinic_phone,
            'clinic_opening_days'           => $clinic->clinicOpeningDays()->join('days', 'days.id', '=', 'clinic_opening_days.day_id')->select('clinic_opening_days.id', 'days.day')->get(),
        ];
    }

}