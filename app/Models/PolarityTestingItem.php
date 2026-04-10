<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolarityTestingItem extends Model
{
    protected $fillable = ['name', 'key', 'section'];

    public function reports()
    {
        return $this->belongsToMany(SafetyCheckReport::class, 'report_polarity_testing_items', 'polarity_testing_item_id', 'report_id');
    }
}
