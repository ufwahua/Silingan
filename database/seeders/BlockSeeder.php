<?php

namespace Database\Seeders;

use App\Models\Lot;
use App\Models\Block;
use Illuminate\Database\Seeder;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $block = Block::create([
            'number' => 1,
        ]);
       for($i = 1;$i<=49;$i++)
        {
            Lot::create([
                'block_id' => $block['id'],
                'number' => $i,
            ]);
        }
        $block = Block::create([
            'number' => 2,
        ]);
       for($i = 1;$i<=49;$i++)
        {
            Lot::create([
                'block_id' => $block['id'],
                'number' => $i,
            ]);
        }
        $block = Block::create([
            'number' => 3,
        ]);
       for($i = 1;$i<=49;$i++)
        {
            Lot::create([
                'block_id' => $block['id'],
                'number' => $i,
            ]);
        }
    }
}
