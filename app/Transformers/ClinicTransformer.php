<?php

namespace App\Transformers;

use App\Models\ClinicDetails;
use League\Fractal\TransformerAbstract;

class ClinicTransformer extends TransformerAbstract
{

    public function transform(ClinicDetails $clinic)
    {
        return [
            'id'               => $clinic->id,
            'clinic_name'             => $clinic->clinic_name,
        ];
    }
}
