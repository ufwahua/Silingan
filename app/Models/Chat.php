<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'chat_room_id',
        'user_id',
        'message',
        
    ];

    public function chat_room(){
        return $this->hasOne(ChatRoom::class,'id','chat_room_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function getCreatedAtAttribute(){
        
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
    }
    
}
