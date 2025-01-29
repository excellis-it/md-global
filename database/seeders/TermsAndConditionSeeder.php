<?php

namespace Database\Seeders;

use App\Models\TermsAndCondition;
use Illuminate\Database\Seeder;

class TermsAndConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = ['Frontend','Doctor','Patient'];

        foreach ($type as $key => $value) {
            $termsAndCondition = new TermsAndCondition();
            $termsAndCondition->type = $value;
            $termsAndCondition->content = 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolorem, reprehenderit ab culpa numquam accusantium nostrum? Animi, architecto! Tenetur eveniet iure minima fuga! Eos deleniti culpa consequatur, neque veritatis harum quos.';
            $termsAndCondition->save();
        }

    }
}
