<?php

namespace Database\Factories;

use App\Models\Lot;
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
        $first_name = $this->faker->firstName();
        $last_name = $this->faker->lastName();
        return [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'role' => $this->faker->randomElement(['admin', 'officer', 'resident','security_officer']),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'gender' => $this->faker->randomElement(['male','female']),
            'block_lot_id' =>  Lot::all()->random()->id,
            'age' => rand(1,100),     
            'verified' => rand(0,1),
            'has_voted' => 0,
            'contact_num' => rand(639111111111,639999999999),
            'email' => strtolower($first_name).".".strtolower($last_name).$this->faker->randomElement(['@gmail.com','@yahoo.com','@hotmail.com','@outlook.com']),
            'password'=> Hash::make("12345678"),
        ];
    }

    
}
