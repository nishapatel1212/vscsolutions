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

    public function inspectionItems()
    {
        return $this->belongsToMany(InspectionItem::class, 'report_inspection_items', 'report_id', 'inspection_item_id');
    }

    public function visualInspectionItems()
    {
        return $this->belongsToMany(VisualInspectionItem::class, 'report_visual_inspection_items', 'report_id', 'visual_inspection_item_id');
    }

    public function polarityTestingItems()
    {
        return $this->belongsToMany(PolarityTestingItem::class, 'report_polarity_testing_items', 'report_id', 'polarity_testing_item_id');
    }

    public function earthTestingItems()
    {
        return $this->belongsToMany(EarthTestingItem::class, 'report_earth_testing_items', 'report_id', 'earth_testing_item_id');
    }

    public function images()
    {
        return $this->hasMany(ReportImage::class, 'report_id');
    }
}
