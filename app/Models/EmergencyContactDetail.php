<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContactDetail extends Model
{
    use HasFactory;

    protected $fillable= [
        'user_id',
        'name',
        'number',
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
