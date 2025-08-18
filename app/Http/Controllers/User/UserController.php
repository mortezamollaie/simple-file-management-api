<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShareLinkDetailResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function links(Request $request)
    {
        $user = $request->user();

        $links = $user->shareLinks;

        $links_count = count($links);

        return apiResponse::success('Links fetched', [
            'count' => $links_count,
            'links' => ShareLinkDetailResource::collection($links)
        ]);
    }
}
