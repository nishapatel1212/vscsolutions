<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fault extends Model
{
    protected $fillable = [
        'report_id',
        'fault',
        'required_rectification',
        'repair_completed',
        'assessment',
        'location',
        'image'
    ];

    public function report()
    {
        return $this->belongsTo(SafetyCheckReport::class, 'report_id');
    }
}
