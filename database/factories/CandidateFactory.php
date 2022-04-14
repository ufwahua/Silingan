<?php

namespace Database\Factories;


use App\Models\User;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'position_id' => Position::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'election_id' => 1,

        ];
    }
}
