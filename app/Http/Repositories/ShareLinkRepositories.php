<?php

namespace App\Http\Repositories;

use App\Models\File;
use App\Models\ShareLink;
use Illuminate\Database\Eloquent\Model;

class ShareLinkRepositories extends BaseRepositories implements ShareLinkRepositoriesInterface
{
    public function __construct(ShareLink $model)
    {
        parent::__construct($model);
    }

    public function getByLink($link)
    {
        return $this->model->where('url', $link)->first();
    }
}
