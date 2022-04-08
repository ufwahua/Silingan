<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Card extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'availability',

    ];

    public function log()
    {
        return $this->hasOne(Log::class, 'card_id', 'id');
    }
}
