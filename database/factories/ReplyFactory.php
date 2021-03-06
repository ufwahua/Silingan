<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Reply;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReplyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reply::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comment_id' => Comment::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'message' =>  $this->faker->realText(200),
        ];
    }
}
