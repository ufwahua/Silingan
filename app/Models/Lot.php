<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lot extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'block_id',
        'number',
    ];
    public function block(){
        return $this->hasOne(Block::class,'id','block_id');
    }
    public function user(){
        return $this->hasMany(User::class,'block_lot_id','id');
    }
}
