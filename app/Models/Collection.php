<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
       'collection_type_id',
       'user_id',
       'block_lot_id',
       'amount',
       'notes' 
    ];

    public function collectionType(){
        return $this->hasOne(CollectionType::class,'id','collection_type_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function lot(){
        return $this->hasMany(Lot::class,'id','block_lot_id');
    }
}
