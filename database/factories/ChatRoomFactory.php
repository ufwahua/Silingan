<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ChatRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatRoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ChatRoom::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        //    'name' =>  $this->faker->unique()->numberBetween(1,User::all()->count())." ".$this->faker->unique()->numberBetween(1,User::all()->count()),
        //    'name' =>  "27 ".$this->faker->unique()->numberBetween(1,User::all()->count()),
           'name' =>  "27 ".$this->faker->unique()->numberBetween(26,27),
        
        ];
    }

    
}
