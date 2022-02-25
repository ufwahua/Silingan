<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'message',
    ];
    public function comment(){
        return $this->hasMany(Comment::class,'id','comment_id');
    }

}
