<?php

namespace Database\Seeders;

use App\Models\ChatRoom;
use App\Models\Election;
use Illuminate\Database\Seeder;
use Database\Seeders\CandidateSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
            BlockSeeder::class,
            PositionSeeder::class,
            UserSeeder::class,
            GroupSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            ReplySeeder::class,
            AnnouncementSeeder::class,
            // ChatRoomSeeder::class,
            // ChatSeeder::class,
            EmergencyContactDetailSeeder::class,
            CandidateSeeder::class,
            CardSeeder::class,
            BlockUserSeeder::class,
            VehicleSeeder::class,
            CollectionTypeSeeder::class,
            FundSeeder::class
        ]);
    }
}
