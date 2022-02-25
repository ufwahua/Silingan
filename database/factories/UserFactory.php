<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'role' => $this->faker->randomElement(['admin', 'officer', 'resident','security_guard']),
            'gender' => $this->faker->randomElement(['male','female']),
            'age' => rand(1,100),     
            'verified' => rand(0,1),
            'has_voted' => 0,
            'contact_num' => rand(11111111111,9999999999),
            'email' => $this->faker->unique()->safeEmail(),
            'password'=> Hash::make("12345678"),
        ];
    }

    
}
