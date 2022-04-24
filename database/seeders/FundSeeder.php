<?php

namespace Database\Seeders;

use App\Models\Fund;
use Illuminate\Database\Seeder;

class FundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fund::create([
            'amount' => 0,
            'fund_type' => 'Association Funds'
        ]);
        Fund::create([
            'amount' => 0,
            'fund_type' => 'Savings'
        ]);
        Fund::create([
            'amount' => 0,
            'fund_type' => 'Maintenance Funds'
        ]);
    }
}
