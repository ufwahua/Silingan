<?php

namespace Database\Seeders;

use App\Models\CollectionType;
use Illuminate\Database\Seeder;

class CollectionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CollectionType::create([
            'name' => 'Association Due',
            'amount' => 150
        ]);

        CollectionType::create([
            'name' => 'Vehicle Sticker',
            'amount' => 100
        ]);

        CollectionType::create([
            'name' => 'Function Hall Rental',
            'amount' => 500
        ]);

        CollectionType::create([
            'name' => 'Swimming Pool Rental',
            'amount' => 200
        ]);
    }
}
