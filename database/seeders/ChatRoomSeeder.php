<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ChatRoom;
use Illuminate\Database\Seeder;

class ChatRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         ChatRoom::factory()
            ->count(2)
            ->create();
    }
}
