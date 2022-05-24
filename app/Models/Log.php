<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_login_id',
        'user_logout_id',
        'card_id',
        'block_lot_id',
        'log_type',
        'vehicle_label',
        'vehicle_type',
        'purpose_visit',
        'name',
        'plate_number',
        'num_passenger',
       
    ];
    public function user_login(){
        return $this->hasOne(User::class,'id','user_login_id');
    }
     public function user_logout(){
        return $this->hasOne(User::class,'id','user_logout_id');
    }
    public function card(){
        return $this->hasOne(Card::class,'id','card_id');
    }
    public function lot(){
        return $this->hasOne(Lot::class, 'id','block_lot_id');
    }
   
    
}
