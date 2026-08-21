<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    protected $fillable = [
        'quote_id',
        'description',
        'quantity',
        'amount',
        'total',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
