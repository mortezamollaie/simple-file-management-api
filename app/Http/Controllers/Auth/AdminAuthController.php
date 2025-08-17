<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminAuthController extends Controller
{
    public function Login(AdminLoginRequest $request)
    {
        $data = $request->validated();

        try {
            if (!$token = JWTAuth::attempt($data)) {
                return ApiResponse::error('Invalid credentials', 401);
            }
        } catch (JWTException $e) {
            return ApiResponse::serverError('Could not create token', 500);
        }

        $user = auth()->user();

        if (! $user->is_admin){
            return ApiResponse::error('User Not Admin', 400);
        }

        return ApiResponse::success(message: 'Login successfully', data: ['token' => $token]);
    }
}
