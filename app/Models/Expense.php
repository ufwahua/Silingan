<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fund_id',
        'expense_type_id',
        'amount',
        'notes',
        'official_receipt',
        'running_balance',
        'expense_source'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function fund(){
        return $this->hasOne(Fund::class,'id','fund_id');
    }
    public function expenseType(){
        return $this->hasOne(ExpenseType::class,'id','expense_type_id');
    }
}
