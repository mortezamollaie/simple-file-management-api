<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Responses\ApiResponse;
use App\Http\services\JWTServices;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuthController extends Controller
{
    public function Login(UserLoginRequest $request)
    {
        $data = $request->validated();

        $token = JWTServices::JWTlogin($data);

        $user = auth()->user();

        if ($user->is_admin){
            return ApiResponse::error('User can not login with this route.', 400);
        }

        return ApiResponse::success(message: 'Login successfully', data: ['token' => $token]);
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
