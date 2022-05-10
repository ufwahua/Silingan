<?php

namespace Database\Seeders;

use App\Models\ExpenseType;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExpenseType::create([
            'name' => 'Maintenance expense'
        ]);
    
        ExpenseType::create([
            'name' => 'Salary expense'
        ]);
        ExpenseType::create([
            'name' => 'Water expense'
        ]);
         ExpenseType::create([
            'name' => 'Electic expense'
        ]);
         ExpenseType::create([
            'name' => 'Miscellaneous expense'
        ]);
    }
}
