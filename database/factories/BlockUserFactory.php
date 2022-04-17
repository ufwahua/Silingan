<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlockUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $varbie = User::where('email','varbiesumido@gmail.com')->first();
        return [
            'user_id' =>  $varbie['id'],
            'block_user_id' => User::all()->random()->id,
        ];
    }
}
