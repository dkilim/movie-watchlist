<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\BaseInterface;

class BaseRepository implements BaseInterface
{

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function create($attributes) : Model
    {
        return $this->create($attributes);
    }


    public function fetchAll()
    {
        return $this->model->all;
    }

    public function update($params, $id)
    {
        $model = $this->model->where('id', $id)->first();
        $model->update($params);
        return $model;
    }

    public function delete($id)
    {
        $model = $this->model->where('id', $id)->first();
        $model->delete();
    }

    public function findById($id)
    {
        return $this->model->where('id', $id)->first();
    }
}