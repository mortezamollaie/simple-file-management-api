<?php

namespace App\Http\services;

use App\Models\ShareLink;
use Illuminate\Support\Str;

class LinkGenerateService
{
    public static function generate()
    {
        do {
            $token = Str::random(25);
        } while (ShareLink::where('url', $token)->exists());

        $url = 'share/'. $token;

        return $url;
    }
}
