<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ShareLinkRepositories;
use App\Http\Requests\ShareLink\ShareLinkCreateRequest;
use App\Http\Resources\ShareLinkDetailResource;
use App\Http\Resources\ShareLinkListResource;
use App\Http\Responses\ApiResponse;
use App\Http\services\LinkGenerateService;
use App\Models\ShareLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ShareLinkController extends Controller
{
    protected $shareLinkRepo;

    public function __construct(ShareLinkRepositories $shareLinkRepo){
        $this->shareLinkRepo = $shareLinkRepo;
    }


    public function list(Request $request)
    {
        $user = $request->user();

        if (! $user->is_admin){
            return ApiResponse::error('Unauthorized');
        }

        $shareLinks = $this->shareLinkRepo->list();

        return ApiResponse::success('link fetch successfully', ShareLinkListResource::collection($shareLinks));
    }

    public function create(ShareLinkCreateRequest $request)
    {
        $input = $request->validated();

        $data = [
            'file_id' => $input['file_id'],
            'user_id' => $input['user_id'],
            'url' => LinkGenerateService::generate(),
            'expires_at' => $input['expires_at'],
        ];

        $link = $this->shareLinkRepo->create($data);

        [$hours, $minutes, $seconds] = explode(':', $link->expires_at);

        $hours = intval($hours);
        $minutes = intval($minutes);
        $seconds = intval($seconds);

        $totalMinutes = $hours * 60 + $minutes + ($seconds > 0 ? 1 : 0);

        $signedUrl = URL::temporarySignedRoute(
            'links.show',
            now()->addMinutes($totalMinutes ),
            ['link' => $link->url]
        );

        $link->full_path = $signedUrl;
        $link->save();

        return apiResponse::success('Link created successfully', [
            'link' => $signedUrl,
        ]);
    }

    public function show(Request $request, $link)
    {
        $user = $request->user();

        $shareLink = $this->shareLinkRepo->getByLink($link);

        if($shareLink->user != $user && !$user->is_admin){
            return ApiResponse::error('Unauthorized');
        } else if (! $shareLink->valid_link){
            return ApiResponse::error('Link was deprecated');
        }

        $filePath = storage_path('app/private/' . $shareLink->file->path);

        $filePath = str_replace('/', '\\', $filePath);

        return response()->file($filePath);
    }
}
