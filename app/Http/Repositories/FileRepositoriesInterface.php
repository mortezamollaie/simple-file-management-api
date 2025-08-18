<?php

namespace App\Http\Repositories;

use App\Models\File;
use App\Models\User;

interface FileRepositoriesInterface
{
    public function uploadByUser(User $user, File $file);
}
