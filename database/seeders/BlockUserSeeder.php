<?php

namespace Database\Seeders;

use App\Models\BlockUser;
use Illuminate\Database\Seeder;

class BlockUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         BlockUser::factory()
            ->count(10)
            ->create();
    }
}
