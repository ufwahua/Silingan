<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Announcement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::where('role','admin')->orWhere('role','officer')->get()->random()->id,
            'title' => $this->faker->text(50),
            'content' => $this->faker->text(200),
        ];
    }
}
