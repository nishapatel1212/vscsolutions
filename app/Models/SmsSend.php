<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsSend extends Model
{
    protected $fillable = [
        'sms_template_id',
        'customer_id',
        'sent_by',
        'phone',
        'message',
        'status',
        'error',
    ];

    public function template()
    {
        return $this->belongsTo(SmsTemplate::class, 'sms_template_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
