<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'user_id',
        'type',
        'make',
        'model',
        'color',
        'plate_number',
        
    ];
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function payment(){
        return $this->hasMany(Payment::class,'vehicle_id','id');
    }
}
