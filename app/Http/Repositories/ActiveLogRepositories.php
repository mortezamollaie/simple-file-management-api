<?php

namespace App\Http\Repositories;

use App\Models\ActiveLog;

class ActiveLogRepositories extends BaseRepositories implements ActiveLogRepositoriesInterface
{
    public function __construct(ActiveLog $model)
    {
        parent::__construct($model);
    }
}
