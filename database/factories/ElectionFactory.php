<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ElectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'start_date' => "2022-03-09",
            'end_date' =>  "2022-03-18",
        ];
    }
}
