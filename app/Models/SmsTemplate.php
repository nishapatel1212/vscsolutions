<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class SmsTemplate extends Model
{
    use Auditable;

    protected $fillable = [
        'name',
        'trigger_type',
        'message',
    ];

    public function sends()
    {
        return $this->hasMany(SmsSend::class);
    }
}
