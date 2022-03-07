<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\EmergencyContactDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmergencyContactDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmergencyContactDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::where('role','admin')->orWhere('role','officer')->get()->random()->id,
            'name' => $this->faker->text(rand(20,50)),
            'number' => $this->faker->text(rand(20,200)),
        ];
    }
}
