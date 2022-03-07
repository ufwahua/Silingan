<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $fillable = [
        'pos_id',
        'user_id',
     
    ];
    public function position(){
        return $this->hasOne(Position::class,'id','pos_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
