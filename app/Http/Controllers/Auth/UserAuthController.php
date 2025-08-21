<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserEvent;
use App\Http\Controllers\Controller;
use App\Http\Repositories\ActiveLogRepositories;
use App\Http\Repositories\FileRepositories;
use App\Http\Repositories\UserRepositories;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Responses\ApiResponse;
use App\Http\services\JWTServices;
use App\Models\ActiveLog;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuthController extends Controller
{
    protected $userRepo;

    protected $activeLogRepo;

    public function __construct(UserRepositories $userRepo, ActiveLogRepositories $activeLogRepo){
        $this->userRepo = $userRepo;
        $this->activeLogRepo = $activeLogRepo;
    }

    public function Login(UserLoginRequest $request)
    {
        $data = $request->validated();

        $token = JWTServices::JWTlogin($data);

        $user = auth()->user();

        if(!$user){
            return ApiResponse::error('Login Failed', 400);
        }

        if ($user->is_admin){
            return ApiResponse::error('User can not login with this route.', 400);
        }

        broadcast(new UserEvent($user));

        $this->activeLogRepo->create(['user_id' => $user->id, 'action_type' => 'login', 'payload', '']);


        return ApiResponse::success(message: 'Login successfully', data: ['token' => $token, 'user_name' => $user->name]);
    }

    public function logout(Request $request)
    {
        $result = JWTServices::JWTLogout();

        if($result){
            return ApiResponse::success('Logout successfully');
        }



        $this->activeLogRepo->create(['user_id' => $request->user->id, 'action_type' => 'logout', 'payload', '']);

        return ApiResponse::error('Logout failed');
    }
}
