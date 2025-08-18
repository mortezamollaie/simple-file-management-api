<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ShareLinkRepository;
use App\Http\Requests\ShareLink\ShareLinkCreateRequest;
use App\Http\Resources\ShareLinkDetailResource;
use App\Http\Resources\ShareLinkListResource;
use App\Http\Responses\ApiResponse;
use App\Http\services\LinkGenerateService;
use Illuminate\Http\Request;

class ShareLinkController extends Controller
{
    protected $shareLinkRepo;

    public function __construct(ShareLinkRepository $shareLinkRepo){
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

        return apiResponse::success('Link created successfully', new ShareLinkDetailResource($link));
    }


}
