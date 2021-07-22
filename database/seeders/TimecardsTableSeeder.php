<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Timecard;

class TimecardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Timecard::factory()->count(3)->create();
    }
}
