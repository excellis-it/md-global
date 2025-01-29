<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Seeder;

class AddDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        foreach ($days as $day) {
           Day::create([
                'day' => $day
            ]);
        }
    }
}
