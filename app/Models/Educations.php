<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Educations extends Model
{
    protected $fillable = ['user_id', 'degree', 'session', 'institution'];
}
