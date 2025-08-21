<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserEvent;
use App\Http\Controllers\Controller;
use App\Http\Repositories\FileRepositories;
use App\Http\Repositories\UserRepositories;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Responses\ApiResponse;
use App\Http\services\JWTServices;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuthController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositories $userRepo){
        $this->userRepo = $userRepo;
    }

    public function Login(UserLoginRequest $request)
    {
        $data = $request->validated();

        $token = JWTServices::JWTlogin($data);

        $user = auth()->user();

        if ($user->is_admin){
            return ApiResponse::error('User can not login with this route.', 400);
        }

        broadcast(new UserEvent($user));

        return ApiResponse::success(message: 'Login successfully', data: ['token' => $token, 'user_name' => $user->name]);
    }

    public function logout()
    {
        $result = JWTServices::JWTLogout();

        if($result){
            return ApiResponse::success('Logout successfully');
        }

        return ApiResponse::error('Logout failed');
    }
}
