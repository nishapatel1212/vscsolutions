<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisualInspectionItem extends Model
{
    protected $fillable = ['name', 'key', 'section'];

    public function reports()
    {
        return $this->belongsToMany(SafetyCheckReport::class, 'report_visual_inspection_items', 'visual_inspection_item_id', 'report_id');
    }
}
