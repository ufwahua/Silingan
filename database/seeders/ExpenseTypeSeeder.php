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
            'name' => 'Maintenance Expense'
        ]);
        ExpenseType::create([
            'name' => 'Utility Expense'
        ]);
        ExpenseType::create([
            'name' => 'Salary Expense'
        ]);
    }
}
