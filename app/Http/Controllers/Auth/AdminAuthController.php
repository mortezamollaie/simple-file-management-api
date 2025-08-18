<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Responses\ApiResponse;
use App\Http\services\JWTServices;

class AdminAuthController extends Controller
{
    public function Login(AdminLoginRequest $request)
    {
        $data = $request->validated();

        $token = JWTServices::JWTlogin($data);

        $user = auth()->user();

        if (! $user->is_admin){
            return ApiResponse::error('User Not Admin', 400);
        }

        return ApiResponse::success(message: 'Login successfully', data: ['token' => $token]);
    }
}
