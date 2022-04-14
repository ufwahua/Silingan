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
        'contact_number',
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    
}
