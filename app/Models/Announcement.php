<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;
    protected $fillable= [
        'user_id',
        'title',
        'content',
    ];

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
