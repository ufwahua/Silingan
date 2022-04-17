<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'card_id',
        'log_type',
        'name',
        'plate_number',
        'status',
    ];
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function card(){
        return $this->hasOne(Card::class,'id','card_id');
    }

    public function getCreatedAtAttribute(){
        
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
    }
    public function getUpdatedAtAttribute(){
        
        return Carbon::createFromTimeStamp(strtotime($this->attributes['updated_at']) )->diffForHumans();
    }
}
