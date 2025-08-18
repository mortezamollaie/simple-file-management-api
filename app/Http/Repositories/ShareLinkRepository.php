<?php

namespace App\Http\Repositories;

use App\Models\File;
use App\Models\ShareLink;
use Illuminate\Database\Eloquent\Model;

class ShareLinkRepository extends BaseRepositories
{
    public function __construct(ShareLink $model)
    {
        parent::__construct($model);
    }
}
