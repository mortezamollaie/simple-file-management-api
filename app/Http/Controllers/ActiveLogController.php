<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ActiveLogRepositoriesInterface;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

class ActiveLogController extends Controller
{
    protected $activeLogRepo;

    public function __construct(ActiveLogRepositoriesInterface $activeLogRepo)
    {
        $this->activeLogRepo = $activeLogRepo;
    }


    public function index(Request $request)
    {
        $user = $request->user();

        if($user->is_admin){
            ApiResponse::error('Unauthorized');
        }

        $data = $this->activeLogRepo->list();

        return ApiResponse::success('ok', $data);
    }

    public function store(Request $request)
    {
        $data = $request->only(['user_id', 'action_type', 'payload']);

        $result = $this->activeLogRepo->create($data);

        return ApiResponse::success('ok', $result);
    }
}
