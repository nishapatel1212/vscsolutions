<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateItem extends Model
{
    protected $fillable = [
        'certificate_id',
        'appliance_name',
        'tag_number',
        'test_result',
        'retest_date',
        'notes',
    ];

    protected $casts = [
        'retest_date' => 'date',
    ];

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }
}
