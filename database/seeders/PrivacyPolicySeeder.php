<?php

namespace Database\Seeders;

use App\Models\PrivacyPolicy;
use Illuminate\Database\Seeder;

class PrivacyPolicySeeder extends Seeder
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
            $privacyPolicy = new PrivacyPolicy();
            $privacyPolicy->type = $value;
            $privacyPolicy->content = 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolorem, reprehenderit ab culpa numquam accusantium nostrum? Animi, architecto! Tenetur eveniet iure minima fuga! Eos deleniti culpa consequatur, neque veritatis harum quos.';
            $privacyPolicy->save();
        }
    }
}
