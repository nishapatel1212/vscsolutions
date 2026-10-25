<?php

// app/Models/Customer.php
namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use Auditable;

    protected $fillable = ['name', 'email', 'phone', 'address', 'notes'];

    public function quotes()
    {
        // Only works once quotes.customer_id exists — see note at the bottom
        return $this->hasMany(Quote::class)->where('type', 'quote');
    }
}
