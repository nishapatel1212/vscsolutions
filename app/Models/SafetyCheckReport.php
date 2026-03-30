<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafetyCheckReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'report_date',
        'previous_safety_date',
        'details',
        'safety_check_status'
    ];

    public function faults()
    {
        return $this->hasMany(Fault::class, 'report_id');
    }
}
