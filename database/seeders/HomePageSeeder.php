<?php

namespace Database\Seeders;

use App\Models\HomePage;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $home_banner_arr = [
            ['title' => 'Meet Healthcare Partner to Help and Facilitate the Overall
            Well Being of Humanity Towards Better Living Conditions', 'sub_title' => 'We specialize in returning Hope to Families affected by
            Natural Disasters Like Fire and Floods to provide Affected
            Families with quality living conditions, accessible Health
            Care.', 'image' => asset('frontend_assets/images/banner-1.jpg'), 'type' => '1'],
            ['title' => 'Meet Healthcare Partner to Help and Facilitate the Overall
            Well Being of Humanity Towards Better Living Conditions', 'sub_title' => 'We specialize in returning Hope to Families affected by
            Natural Disasters Like Fire and Floods to provide Affected
            Families with quality living conditions, accessible Health
            Care.', 'image' => asset('frontend_assets/images/banner-1.jpg'), 'type' => '1'],
            ['title' => 'Meet Healthcare Partner to Help and Facilitate the Overall
            Well Being of Humanity Towards Better Living Conditions', 'sub_title' => 'We specialize in returning Hope to Families affected by
            Natural Disasters Like Fire and Floods to provide Affected
            Families with quality living conditions, accessible Health
            Care.', 'image' => asset('frontend_assets/images/banner-1.jpg'), 'type' => '1'],
            ['title' => 'Meet Healthcare Partner to Help and Facilitate the Overall
            Well Being of Humanity Towards Better Living Conditions', 'sub_title' => 'We specialize in returning Hope to Families affected by
            Natural Disasters Like Fire and Floods to provide Affected
            Families with quality living conditions, accessible Health
            Care.', 'image' => asset('frontend_assets/images/banner-1.jpg'), 'type' => '1']

        ];

        $home_body_arr = [
            ['title' => 'High Yield Projects', 'sub_title' => 'We are the best', 'image' => asset('frontend_assets/images/sr-2.png'), 'type' => '2'],
            ['title' => 'High Yield Projects', 'sub_title' => 'We are the best', 'image' => asset('frontend_assets/images/sr-2.png'), 'type' => '2'],
            ['title' => 'High Yield Projects', 'sub_title' => 'We are the best', 'image' => asset('frontend_assets/images/sr-2.png'), 'type' => '2'],
            ['title' => 'High Yield Projects', 'sub_title' => 'We are the best', 'image' => asset('frontend_assets/images/sr-2.png'), 'type' => '2'],
            ['title' => 'High Yield Projects', 'sub_title' => 'We are the best', 'image' => asset('frontend_assets/images/sr-2.png'), 'type' => '2'],
            ['title' => 'High Yield Projects', 'sub_title' => 'We are the best', 'image' => asset('frontend_assets/images/sr-2.png'), 'type' => '2'],
            ['title' => 'High Yield Projects', 'sub_title' => 'We are the best', 'image' => asset('frontend_assets/images/sr-2.png'), 'type' => '2'],
            ['title' => 'High Yield Projects', 'sub_title' => 'We are the best', 'image' => asset('frontend_assets/images/sr-2.png'), 'type' => '2']
        ];

        foreach ($home_banner_arr as $key => $value) {
            HomePage::create($value);
        }

        foreach ($home_body_arr as $key => $value) {
            HomePage::create($value);
        }
    }
}
