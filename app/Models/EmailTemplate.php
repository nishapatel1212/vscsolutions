<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use Auditable;

    protected $fillable = [
        'name',
        'subject',
        'body',
    ];

    public function sends()
    {
        return $this->hasMany(EmailSend::class);
    }
}
