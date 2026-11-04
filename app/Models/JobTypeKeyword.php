<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class JobTypeKeyword extends Model
{
    use Auditable;

    protected $fillable = ['keyword', 'job_type', 'category', 'active'];

    public function auditLabel(): ?string
    {
        return $this->keyword;
    }
}
