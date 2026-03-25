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
        'details'
    ];
}
