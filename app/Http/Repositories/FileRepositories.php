<?php

namespace App\Http\Repositories;

use App\Models\File;

class FileRepositories extends BaseRepositories
{
    public function __construct(File $model)
    {
        parent::__construct($model);
    }

    public function uploadByUser($user, $data)
    {
        return $user->files()->create([
            'name' => $data['name'],
            'type' => $data['type'],
            'size' => $data['size'],
            'path' => $data['path'],
        ]);
    }
}
