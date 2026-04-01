<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionItem extends Model
{
    protected $fillable = ['name', 'key', 'section'];

    public function reports()
    {
        return $this->belongsToMany(SafetyCheckReport::class, 'report_inspection_items');
    }
}
