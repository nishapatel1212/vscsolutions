<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EarthTestingItem extends Model
{
    protected $fillable = ['name', 'key', 'section'];

    public function reports()
    {
        return $this->belongsToMany(SafetyCheckReport::class, 'report_earth_testing_items', 'earth_testing_item_id', 'report_id');
    }
}
