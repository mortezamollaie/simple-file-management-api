<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class File extends Model
{
    protected $fillable = [
        'name',
        'path',
        'type',
        'size',
        'user_id',
    ];

    public function users(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function shareLinks(): HasMany
    {
        return $this->hasMany(ShareLink::class);
    }
}
