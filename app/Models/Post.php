<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_id',
        'user_id',
        'images',
        'content',
    ];
    public function group(){
        return $this->hasOne(Group::class,'id','group_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function comment(){
        return $this->hasMany(Comment::class);
    }
    public function reply(){
         return $this->hasManyThrough(Reply::class,Comment::class);
    }

    public function getCreatedAtAttribute(){
        
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
    }
    public function getUpdatedAtAttribute(){
        
        return Carbon::createFromTimeStamp(strtotime($this->attributes['updated_at']) )->diffForHumans();
    }
}
