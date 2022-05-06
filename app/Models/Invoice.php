<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id_from',
        'collection_type_id',
        'block_lot_id',
        'due_date',
        'running_balance',
        'over_due',
        'payment',
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id_from');
    }
    public function collection_type(){
        return $this->hasOne(CollectionType::class,'id','collection_type_id' );
    }
    public function lot(){
        return $this->hasOne(Lot::class,'id','block_lot_id');
    }
   
     public function getDueDateAttribute()
    {
        $date = strtotime($this->attributes['due_date']);
        $date =  strtotime("+1 day", $date);
        return Carbon::parse($date)->format('M, d, Y');
    }
}
