<?php

namespace Database\Factories;

use App\Models\Rest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class RestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $now = \Carbon\Carbon::now();
        $carbon = new Carbon('12:00:00');
        return [
            'rest_start' =>  $carbon(),
            'rest_finish' => $carbon->addHours()
        ];
    }
}
