<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ActiveLogRepositories;
use App\Http\Repositories\FileRepositories;
use App\Http\Requests\File\FileDeleteRequest;
use App\Http\Requests\File\FileUploadRequest;
use App\Http\Resources\FileListResource;
use App\Http\Responses\ApiResponse;
use App\Models\File;
use App\Models\ShareLink;
use Illuminate\Http\Request;

class FileController extends Controller
{
    protected $fileRepo;

    protected $activeLogRepo;

    public function __construct(FileRepositories $fileRepo, ActiveLogRepositories $activeLogRepo){
        $this->fileRepo = $fileRepo;

        $this->activeLogRepo = $activeLogRepo;
    }

    public function list(Request $request)
    {
        $user = $request->user();

        if(! $user->is_admin){
            return ApiResponse::error('Unauthorized');
        }

        $files = $this->fileRepo->list();

        $this->activeLogRepo->create(['user_id' => $user->id, 'action_type' => 'get files list', 'payload', 'admin']);

        return ApiResponse::success('Files List', FileListResource::collection($files));
    }

    public function upload(FileUploadRequest $request)
    {
        $user = $request->user();

        $data = $request->validated()['files'];

        $files = [];

        foreach ($data as $file) {
            $path = $file->storeAs('uploads', $file->getClientOriginalName(), 'local');
            $file = $this->fileRepo->uploadByUser($user, [
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
            ]);

            $files[] = $file;
        }

        $this->activeLogRepo->create(['user_id' => $user->id, 'action_type' => 'upload files', 'payload', 'admin']);

        return ApiResponse::success('Files uploaded successfully.', FileListResource::collection($files));
    }

    public function delete(FileDeleteRequest $request)
    {
        $data = $request->validated()['ids'];

        foreach($data as $id){
            $this->fileRepo->delete($id);
        }

        $this->activeLogRepo->create(['user_id' => $request->user->id, 'action_type' => 'delete files', 'payload', 'admin']);

        return ApiResponse::success('Files deleted successfully.');
    }


    public function showAdminFile(Request $request, $id)
    {
        $user = $request->user();

        $file = ShareLink::query()->findOrFail($id)->file;

        if(! $user->is_admin){
            return ApiResponse::error('Unauthorized');
        }

        $filePath = storage_path('app/private/' . $file->path);

        $filePath = str_replace('/', '\\', $filePath);

        $this->activeLogRepo->create(['user_id' => $user->id, 'action_type' => 'showing file', 'payload', "file $file->name"]);

        return response()->file($filePath);
    }
}
