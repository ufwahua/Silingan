<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockUser extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'block_user_id',

     
    ];
    public function block_user(){
        return $this->hasOne(User::class,'id','block_user_id');
    }
}
