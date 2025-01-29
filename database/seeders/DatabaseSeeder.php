<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            assignRoleSeeder::class,
            assignAdminSeeder::class,
            AddQnaSeeder::class,
            ContactPageCmsSeeder::class,
            AddPlanSeeder::class,
            AboutUsSeeder::class,
            PrivacyPolicySeeder::class,
            AddDaySeeder::class,
            HomePageSeeder::class,
            TermsAndConditionSeeder::class,
            FooterSeeder::class,
            TelehealthSeeder::class,
        ]);
    }
}
