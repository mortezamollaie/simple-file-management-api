<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActiveLog extends Model
{
    protected $fillable = [
      'user_id',
      'action_type',
      'payload',
    ];
}
