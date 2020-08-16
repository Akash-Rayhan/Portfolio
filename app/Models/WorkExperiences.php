<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperiences extends Model
{
    protected $fillable = ['user_id', 'company_name', 'job_position'];
}
