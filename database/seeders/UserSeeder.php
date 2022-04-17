<?php

namespace Database\Seeders;


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
            ->count(100)
            ->create();

        User::create([
            'first_name' => "Joshua Henry",
            'last_name' => "Diamos",
            'role' => 'admin',
            'status' => 'active',
            'block_lot_id' => null,
            'gender' => 'male',
            'age' => rand(1, 100),
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => '639083024328',
            'email' => 'jh.diamos@gmail.com',
            'password' => Hash::make("12345678"),
            'tag_as' => 'owner',
        ]);

        User::create([
            'first_name' => "Joshua Henry",
            'last_name' => "Diamos",
            'role' => 'security officer',
            'status' => 'active',
            'block_lot_id' => null,
            'gender' => 'male',
            'age' => rand(1, 100),
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(639000000001, 639999999999),
            'email' => 'joshua.diamos@gmail.com',
            'password' => Hash::make("12345678"),

        ]);

        User::create([
            'first_name' => "Varbie",
            'last_name' => "Sumido",
            'role' => 'resident',
            'status' => 'active',
            'block_lot_id' => 3,
            'gender' => 'female',
            'age' => rand(1, 100),
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => '639083024328',
            'email' => 'varbiesumido@gmail.com',
            'password' => Hash::make("12345678"),
            'tag_as' => 'owner',
        ]);

        User::create([
            'first_name' => "Reynard",
            'last_name' => "Dahunan",
            'role' => 'resident',
            'status' => 'active',
            'gender' => 'male',
            'block_lot_id' => 4,
            'age' => rand(1, 100),
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => '639484807961',
            'email' => 'reynard.dahunan@gmail.com',
            'password' => Hash::make("12345678"),
            'tag_as' => 'owner',
        ]);
        User::create([
            'first_name' => "Joshua Henry",
            'last_name' => "Diamos",
            'role' => 'officer',
            'position_id' => 1,
            'status' => 'active',
            'block_lot_id' => 2,
            'gender' => 'male',
            'age' => rand(1, 100),
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(639000000001, 639999999999),
            'email' => 'jh.officer@gmail.com',
            'password' => Hash::make("12345678"),
            'tag_as' => 'owner',
        ]);
        User::create([
            'first_name' => "Steven Mitch",
            'last_name' => "Espina",
            'role' => 'officer',
            'position_id' => 2,
            'status' => 'active',
            'gender' => 'male',
            'block_lot_id' => 6,
            'age' => rand(1, 100),
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(639000000001, 639999999999),
            'email' => 'stevenmitch.espina@gmail.com',
            'password' => Hash::make("12345678"),
            'tag_as' => 'owner',
        ]);

        User::create([
            'first_name' => "Rodrigo",
            'last_name' => "Natad",
            'role' => 'officer',
            'position_id' => 3,
            'status' => 'active',
            'gender' => 'male',
            'block_lot_id' => 7,
            'age' => rand(1, 100),
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(639000000001, 639999999999),
            'email' => 'rodrigo.natad@gmail.com',
            'password' => Hash::make("12345678"),
            'tag_as' => 'owner',
        ]);

        User::create([
            'first_name' => "Warren",
            'last_name' => "Ngujo",
            'role' => 'officer',
            'position_id' => 4,
            'status' => 'active',
            'gender' => 'male',
            'block_lot_id' => 8,
            'age' => rand(1, 100),
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(639000000001, 639999999999),
            'email' => 'warren.ngujo@gmail.com',
            'password' => Hash::make("12345678"),
            'tag_as' => 'owner',
        ]);

        User::create([
            'first_name' => "Guila Mae",
            'last_name' => "Bagolor",
            'role' => 'officer',
            'position_id' => 5,
            'status' => 'active',
            'gender' => 'female',
            'block_lot_id' => 9,
            'age' => rand(1, 100),
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(639000000001, 639999999999),
            'email' => 'guilamae.bagolor@gmail.com',
            'password' => Hash::make("12345678"),
            'tag_as' => 'owner',
        ]);

        User::create([
            'first_name' => "Kent Luke",
            'last_name' => "Pescadero",
            'role' => 'officer',
            'position_id' => 6,
            'status' => 'active',
            'gender' => 'male',
            'block_lot_id' => 10,
            'age' => rand(1, 100),
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(639000000001, 639999999999),
            'email' => 'kentluke.pescadero@gmail.com',
            'password' => Hash::make("12345678"),
            'tag_as' => 'owner',
        ]);



        User::create([
            'first_name' => "Rika Mae",
            'last_name' => "Diamos",
            'role' => 'officer',
            'position_id' => 7,
            'status' => 'active',
            'gender' => 'male',
            'block_lot_id' => 12,
            'age' => rand(1, 100),
            'verified' => 1,
            'has_voted' => 0,
            'contact_num' => rand(639000000001, 639999999999),
            'email' => 'rikamae.diamos@gmail.com',
            'password' => Hash::make("12345678"),
            'tag_as' => 'owner',
        ]);
    }
}
