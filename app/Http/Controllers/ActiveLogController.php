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

        ApiResponse::success('ActiveLogList', $this->activeLogRepo->list());
    }
}
