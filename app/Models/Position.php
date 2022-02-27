<?php

namespace App\Models;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;
    protected $fillable= [
        'name',
    ];

    public function candidate(){
        return $this->hasOne(Candidate::class,'id','position_id');
    }
}
