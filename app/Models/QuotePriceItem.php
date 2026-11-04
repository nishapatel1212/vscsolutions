<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class QuotePriceItem extends Model
{
    use Auditable;

    protected $fillable = [
        'keyword',
        'description',
        'amount',
        'category',
        'active',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'active' => 'boolean',
    ];

    public function auditLabel(): ?string
    {
        return $this->keyword;
    }
}
