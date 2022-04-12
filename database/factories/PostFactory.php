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
        $group_id = Group::all()->random()->id;
        return [
            'group_id' => $group_id,
            'user_id' => User::all()->random()->id,
            'content' =>  $this->faker->realText(rand(20,200)),
            'approved' =>  $group_id === 1 ? 1 : rand(0,1),
           
        ];
    }
}
