<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::all()->random()->id;
        $type =  $this->faker->randomElement(['motorcycle','car','van','truck','tricycle']);
        $tag = $this->faker->randomElement(['private','public']);
        $car = $this->faker->randomElement(['Toyota', 'Mitsubishi','Nissan','Ford','Suzuki']);
        $motorcycle = $this->faker->randomElement(['Honda', 'Yamaha','Suzuki','Kawasaki']);
        return [
           'user_id' => $user,
            'type' => $type ,
            'make' => $type == 'car'? $car : $motorcycle,
            'model' => $type == 'car'? $car : $motorcycle ." ". strtoupper( $this->faker->word()).rand(11,99),
            'color' => $this->faker->randomElement(['Blue','Black','Gray','Red','Green','Yellow']),       
            'plate_number' => strtoupper( $this->faker->word()) ." ". rand(111,999),
        ];
    }
}
