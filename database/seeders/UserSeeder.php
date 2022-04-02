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
            ->count(50)
            ->create();

        User::create([
            'first_name' => "Joshua Henry",
            'last_name' => "Diamos",
            'role' => 'admin',
            'block_lot_id' => 1,
            'gender' =>'male',
            'age' => rand(1,100),     
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(11111111111,9999999999),
            'email' => 'jh.diamos@gmail.com',
            'password'=> Hash::make("12345678"),
        ]);
        User::create([
            'first_name' => "Joshua Henry",
            'last_name' => "Diamos",
            'role' => 'officer',
            'block_lot_id' => 1,
            'gender' =>'male',
            'age' => rand(1,100),     
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(11111111111,9999999999),
            'email' => 'jh.officer@gmail.com',
            'password'=> Hash::make("12345678"),
        ]);
        User::create([
            'first_name' => "Joshua Henry",
            'last_name' => "Diamos",
            'role' => 'security_officer',
            'block_lot_id' => 1,
            'gender' =>'male',
            'age' => rand(1,100),     
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(11111111111,9999999999),
            'email' => 'jh.security@gmail.com',
            'password'=> Hash::make("12345678"),
        ]);
        
        User::create([
            'first_name' => "Varbie",
            'last_name' => "Sumido",
            'role' => 'resident',
            'block_lot_id' => 2,
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
            'block_lot_id' => 3,
            'age' => rand(1,100),     
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(11111111111,9999999999),
            'email' => 'reynard.dahunan@gmail.com',
            'password'=> Hash::make("12345678"),
        ]);

        User::create([
            'first_name' => "tes",
            'last_name' => "test",
            'role' => 'resident',
            'gender' =>'male',
            'block_lot_id' => 3,
            'age' => rand(1,100),     
            'verified' => 0,
            'has_voted' => 0,
            'contact_num' => rand(11111111111,9999999999),
            'email' => 'test@gmail.com',
            'password'=> Hash::make("12345678"),
        ]);
    }
}
