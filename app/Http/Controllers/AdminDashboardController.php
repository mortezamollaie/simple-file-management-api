<?php

namespace App\Http\Controllers;

use App\Http\Repositories\FileRepositories;
use App\Http\Repositories\UserRepositories;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected $fileRepo;

    protected $userRepo;

    public function __construct(FileRepositories $fileRepo, UserRepositories $userRepo){
        $this->fileRepo = $fileRepo;
        $this->userRepo = $userRepo;
    }

    public function Dashboard(Request $request)
    {
        $user = $request->user();

        if (! $user->is_admin){
            return ApiResponse::error(403, 'Unauthorized');
        }

        $total_files = $this->fileRepo->count();

        $total_users = $this->userRepo->UsersCount();

        $total_storage = $this->fileRepo->fileStorageUsed();

        return ApiResponse::success('dashboard data', [
            'total_files' => $total_files,
            'total_users' => $total_users,
            'total_storage' => $total_storage
        ]);
    }

    public function createLink(Request $request)
    {
        $user = $request->user();

        if (! $user->is_admin){
            return ApiResponse::error(403, 'Unauthorized');
        }

        $users = $this->userRepo->JustUsersList();

        $files = $this->fileRepo->list();

        return ApiResponse::success('success', [
            'users' => $users,
            'files' => $files,
        ]);
    }
}
