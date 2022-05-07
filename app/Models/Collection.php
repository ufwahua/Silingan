<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
       'collection_type_id',
       'fund_id',
       'user_id',
       'block_lot_id',
       'amount',
       'notes',
       'running_balance'
    ];

    public function collectionType(){
        return $this->hasOne(CollectionType::class,'id','collection_type_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function lot(){
        return $this->hasOne(Lot::class,'id','block_lot_id');
    }
    public function fund(){
        return $this->hasOne(Fund::class,'id','fund_id');
    }
}
