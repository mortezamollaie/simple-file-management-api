<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class ShareLink extends Model
{
    protected $fillable = [
        'user_id',
        'file_id',
        'url',
        'expires_at',
        'full_path'
    ];

    protected $appends = ['expires_time', 'valid_link'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function getExpiresTimeAttribute()
    {
        $created = $this->created_at;

        [$hours, $minutes, $seconds] = explode(':', $this->expires_at);

        $interval = CarbonInterval::hours($hours)
            ->minutes($minutes)
            ->seconds($seconds);

        return $created->copy()->add($interval);
    }

    public function getValidLinkAttribute()
    {
        $expiresTime = $this->expires_time;

        $now = Carbon::now();

        return $expiresTime->greaterThan($now);
    }
}
