<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'customer_id',
        'name',
        'email',
        'phone',
        'message',
        'job_type',
        'source',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
