<?php

namespace Database\Factories;

use App\Models\Timecard;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class TimecardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Timecard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $now = \Carbon\Carbon::now();
        $carbon = new Carbon('09:00:00');
        return [
            'date' => date('Y-m-d'),
            'work_start' => $carbon,
            'work_finish' => $carbon->addHours(9)
        ];
    }
}
