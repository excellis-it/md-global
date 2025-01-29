<?php

namespace Database\Seeders;

use App\Models\ContactPageCms;
use Illuminate\Database\Seeder;

class ContactPageCmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contactPageCms = new ContactPageCms();
        $contactPageCms->contact_page_title = 'Contact Us';
        $contactPageCms->visit_us = 'Vi17581 Sultana St, Hesperia, CA
        92345, USA';
        $contactPageCms->call_us = '760-881-1141';
        $contactPageCms->mail_us = 'info@mdglobal.org';
        $contactPageCms->save();

    }
}
