<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\User;
use App\Models\ChatRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       
        return [
            'chat_room_id' => ChatRoom::all()->random()->id,
            'user_id' => rand(26,27),
            'message' => $this->faker->text(rand(20,200)),
        ];
    }
}
