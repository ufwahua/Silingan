<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function post(){
        return $this->hasMany(Post::class,'id','group_id');
    }
    
}
