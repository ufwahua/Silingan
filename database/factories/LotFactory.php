<?php

namespace Database\Factories;


use App\Models\Lot;
use App\Models\Block;
use Illuminate\Database\Eloquent\Factories\Factory;

class LotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'block_id' => Block::all()->random()->id,
            'number' =>  $this->faker->unique(true)->numberBetween(1, 50),
        ];
    }
}
