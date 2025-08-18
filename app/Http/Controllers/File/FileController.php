<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Repositories\FileRepositories;
use App\Http\Requests\File\FileUploadRequest;
use App\Http\Resources\FileListResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    protected $fileRepo;

    public function __construct(FileRepositories $fileRepo){
        $this->fileRepo = $fileRepo;
    }

    public function upload(FileUploadRequest $request)
    {
        $user = $request->user();

        $data = $request->validated()['files'];

        $files = [];

        foreach ($data as $file) {
            $path = $file->storeAs('uploads', $file->getClientOriginalName(), 'public');
            $file = $this->fileRepo->uploadByUser($user, [
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
            ]);

            $files[] = $file;
        }

        return ApiResponse::success('Files uploaded successfully.', $files);
    }

    public function list(Request $request)
    {
        $user = $request->user();

        if(! $user->is_admin){
            return ApiResponse::error('Unauthorized');
        }

        $files = $this->fileRepo->list();

        return ApiResponse::success('Files List', FileListResource::collection($files));
    }


}
