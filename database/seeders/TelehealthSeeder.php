<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TelehealthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('telehealth_cms')->insert([
            'symptom_title' => 'Not feeling too well?',
            'symptom_description' => 'Treat common symptoms with top specialists',
            'offer_image_1' => null,
            'offer_image_2' => null,
            'offer_image_3' => null,
            'specialization_title' => 'Book appointments with top specialist in your city',
            'how_it_works_title' => 'How It Works',
            'how_it_works_icon_1' => null,
            'how_it_works_icon_2' => null,
            'how_it_works_icon_3' => null,
            'how_it_works_icon_1_title' => 'Select a specialty or symptom',
            'how_it_works_icon_2_title' => 'Video call with a verified doctor',
            'how_it_works_icon_3_title' => 'Get a digital prescription & a free follow-up',
        ]);
    }
}
