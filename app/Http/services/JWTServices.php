<?php

namespace App\Http\services;

use App\Http\Responses\ApiResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTServices
{
    public static function JWTLogin($data)
    {
        try {
            if (!$token = JWTAuth::attempt($data)) {
                return ApiResponse::error('Invalid credentials', 401);
            }
        } catch (JWTException $e) {
            return ApiResponse::serverError('Could not create token', 500);
        }

        return $token;
    }
}
