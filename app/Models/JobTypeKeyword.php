<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobTypeKeyword extends Model
{
    protected $fillable = ['keyword', 'job_type', 'category', 'active'];
}
