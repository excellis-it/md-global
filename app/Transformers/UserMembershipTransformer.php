<?php

namespace App\Transformers;

use App\Models\UserMembership;
use League\Fractal\TransformerAbstract;

class UserMembershipTransformer extends TransformerAbstract
{
    public function transform(UserMembership $membership)
    {
        return [
            'id' => $membership->id,
            'amount' => $membership->amount,
            'membership_expiry_date' => $membership->membership_expiry_date,
            'currency'  => $membership->currency,
            'plan_name'  => $membership->plan->plan_name,
            'plan_duration'  => $membership->plan->plan_duration
        ];
    }
}