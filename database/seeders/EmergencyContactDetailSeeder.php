<?php

namespace Database\Seeders;

use App\Models\EmergencyContactDetail;
use Illuminate\Database\Seeder;

class EmergencyContactDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //EmergencyContactDetail

        EmergencyContactDetail::factory()
            ->count(5)
            ->create();
    }
}
