<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'notes',
        'official_receipt'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}