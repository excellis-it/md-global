<?php

namespace Database\Seeders;

use App\Models\FooterSocialLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('footer_cms')->insert([
            'footer_description' => 'We are a team of talented developers and designers who are passionate about creating the best websites and mobile applications for our clients. We are a team of talented developers and designers who are passionate about creating the best websites and mobile applications for our clients.',
            'website_name' => 'MD Global',
            'address' => '17581 Sultana St, Hesperia, CA 92345, USA',
            'email' => 'info@mdglobal.org',
            'phone' => '760-881-1141 / 855-695-1377',
            'business_phone' => '760-486-2571',
            'newsletter_title' => 'Don’t miss our future updates! Get in touch today!',
        ]);
        $data = DB::table('footer_cms')->orderBy('id', 'desc')->first();
        $links =  array(
            [
                'footer_cms_id' => $data->id,
                'icon' => 'fa-brands fa-facebook',
                'link' => 'https://www.facebook.com/',
            ],
            [
                'footer_cms_id' => $data->id,
                'icon' => 'fa-brands fa-twitter',
                'link' => 'https://twitter.com/',
            ],
            [
                'footer_cms_id' => $data->id,
                'icon' => 'fa-brands fa-instagram',
                'link' => 'https://www.instagram.com/',
            ],
            [
                'footer_cms_id' => $data->id,
                'icon' => 'fa-brands fa-youtube',
                'link' => 'https://www.youtube.com/',
            ],
        );

        foreach ($links as $link) {
            FooterSocialLink::create($link);
        }

    }
}
