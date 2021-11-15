<?php

namespace App\Repository;

class BaseRepository
{
    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    public function first()
    {
        return $this->model->first();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function getByAttribute(string $field, string $attribute)
    {
        return $this->model->where($field, $attribute);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function updateById(array $data, int $id)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function getWithRelation(string $relation)
    {
        return $this->model->with($relation)->get();
    }
}
