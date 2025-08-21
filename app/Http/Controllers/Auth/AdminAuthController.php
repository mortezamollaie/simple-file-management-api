<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ActiveLogRepositories;
use App\Http\Repositories\UserRepositories;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Responses\ApiResponse;
use App\Http\services\JWTServices;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    protected $activeLogRepo;

    public function __construct(ActiveLogRepositories $activeLogRepo){
        $this->activeLogRepo = $activeLogRepo;
    }

    public function Login(AdminLoginRequest $request)
    {
        $data = $request->validated();

        $token = JWTServices::JWTlogin($data);

        $user = auth()->user();

        if(!$user){
            return ApiResponse::error('Login Failed', 400);
        }

        if (! $user->is_admin){
            return ApiResponse::error('User Not Admin', 400);
        }

        $this->activeLogRepo->create(['user_id' => $user->id, 'action_type' => 'login', 'payload', 'admin']);

        return ApiResponse::success(message: 'Login successfully', data: ['token' => $token]);
    }

    public function logout(Request $request)
    {
        $result = JWTServices::JWTLogout();

        if($result){
            return ApiResponse::success('Logout successfully');
        }

        $this->activeLogRepo->create(['user_id' => $request->user->id, 'action_type' => 'login - admin', 'payload', 'admin']);

        return ApiResponse::error('Logout failed');
    }
}
