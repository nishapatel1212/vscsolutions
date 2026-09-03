<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'quote_number',
        'quote_date',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'subtotal',
        'tax',
        'total',
        'notes',
        'type',
        'source_quote_id'
    ];

    protected $casts = [
        'quote_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function invoiceCopy()
    {
        return $this->hasOne(Quote::class, 'source_quote_id')->where('type', 'invoice');
    }
}
