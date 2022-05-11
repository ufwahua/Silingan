<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'user_id',
        'message',
    ];
    public function comment(){
        return $this->hasMany(Comment::class,'id','comment_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
     public function getCreatedAtAttribute(){
        
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
    }
    public function getUpdatedAtAttribute(){
        
        return Carbon::createFromTimeStamp(strtotime($this->attributes['updated_at']) )->diffForHumans();
    }
}
