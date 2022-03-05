<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        
    ];
    public function chats(){
        return $this->hasMany(Chat::class,'chat_room_id','id');
    }
}
