<?php

namespace App\Models;


use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'block_lot_id',
        'email',
        'password',
        'first_name',
        'last_name',
        'gender',
        'age',
        'contact_num',
        'profile_pic',
     
        'verified',
        'status',
        'role',
        'position_id',
        'tag_as',
        'security_shift',
        'flagged',
    ];
    //relationships
    public function post(){
        return $this->hasMany(Post::class,'id','user_id');
    }
    public function lot(){
        return $this->hasOne(Lot::class,'id','block_lot_id');
    }
    public function position(){
        return $this->hasOne(Position::class,'id','position_id');
    }
    public function emergency_contact(){
        return $this->hasMany(EmergencyContactDetail::class,'user_id','id');
    }
  
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $url = 'http://127.0.0.1:8000/reset-password?token='.$token;
        $this->notify(new ResetPasswordNotification($url));
    }
}
