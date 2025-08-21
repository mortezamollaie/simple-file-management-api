<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepositories extends BaseRepositories implements UserRepositoriesInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function UsersCount()
    {
        return $this->model->query()->where('is_admin', false)->count();
    }

    public function JustUsersList()
    {
        return $this->model->query()->where('is_admin', false)->get();
    }
}
