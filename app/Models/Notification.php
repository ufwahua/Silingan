<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    protected $fillable= [
        'from_user_id',
        'to_user_id',
        'chat_room_id',
        'message',
        'viewed'
    ];
 /**
     * @return BelongsTo
     */
    public function from_user() 
    {
        return $this->hasOne(User::class,'id','from_user_id');
    }
    public function to_user() 
    {
        return $this->hasOne(User::class,'id','to_user_id');
    }

    public function getCreatedAtAttribute(){
        
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
    }
    public function getUpdatedAtAttribute(){
        
        return Carbon::createFromTimeStamp(strtotime($this->attributes['updated_at']) )->diffForHumans();
    }
}
