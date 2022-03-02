<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Group;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'group_id' => Group::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'content' =>  $this->faker->text(rand(20,200)),
           
        ];
    }
}
