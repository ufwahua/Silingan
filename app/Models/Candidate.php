<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $fillable = [
        'position_id',
        'user_id',
        'election_id',
        'vote_count',
     
    ];
    public function position(){
        return $this->hasOne(Position::class,'id','position_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function election(){
        return $this->hasOne(Election::class,'id','election_id');
    }
}
