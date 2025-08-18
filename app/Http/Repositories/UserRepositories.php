<?php

namespace App\Http\Repositories;

use App\Models\ShareLink;

class UserRepositories extends BaseRepositories implements UserRepositoriesInterface
{
    public function __construct(ShareLink $model)
    {
        parent::__construct($model);
    }
}
