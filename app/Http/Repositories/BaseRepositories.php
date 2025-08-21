<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepositories implements BaseRepositoriesInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        return $this->model->all();
    }

    public function create($data)
    {
        return $this->model->query()->create($data);
    }

    public function getById(int $id)
    {
        return $this->model->query()->findOrFail($id);
    }

    public function update($id, $data)
    {
        $obj = $this->model->query()->findOrFail($id);

        return $obj->update($data);
    }

    public function delete($id)
    {
        $obj = $this->model->query()->findOrFail($id);

        return $obj->delete();
    }

    public function count()
    {
        return $this->model->query()->count();
    }


}
