<?php

namespace Database\Seeders;


use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    
    public function run()
    {
        User::factory()
            ->count(25)
            ->create();

        User::create([
            'first_name' => "Joshua Henry",
            'last_name' => "Diamos",
            'role' => 'admin',
            'gender' =>'male',
            'age' => rand(1,100),     
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(11111111111,9999999999),
            'email' => 'jh.diamos@gmail.com',
            'password'=> Hash::make("12345678"),
        ]);
        
        User::create([
            'first_name' => "Varbie",
            'last_name' => "Sumido",
            'role' => 'resident',
            'gender' =>'female',
            'age' => rand(1,100),     
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(11111111111,9999999999),
            'email' => 'varbie.sumido@gmail.com',
            'password'=> Hash::make("12345678"),
        ]);

        User::create([
            'first_name' => "Reynard",
            'last_name' => "Dahunan",
            'role' => 'resident',
            'gender' =>'male',
            'age' => rand(1,100),     
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(11111111111,9999999999),
            'email' => 'reynard.dahunan@gmail.com',
            'password'=> Hash::make("12345678"),
        ]);
    }
}
