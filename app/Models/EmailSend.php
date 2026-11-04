<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSend extends Model
{
    protected $fillable = [
        'email_template_id',
        'customer_id',
        'sent_by',
        'email',
        'status',
        'error',
    ];

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'email_template_id');
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
