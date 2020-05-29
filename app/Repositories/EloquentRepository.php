<?php

namespace App\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * EloquentRepository constructor.
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Get model.
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model.
     * @throws BindingResolutionException
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Get all.
     *
     * @return Collection|static[]
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->model->find($id);
        if ($result) {
            $this->model = $result;
        }
        return $result;
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function findWithTrashed($id)
    {
        $result = $this->model->withTrashed()->find($id);
        if ($result) {
            $this->model = $result;
        }
        return $result;
    }

    /**
     * Get one
     * @param $id
     * @return mixed or false
     */
    public function findOrFail($id)
    {
        $result = $this->model->findOrFail($id);
        if ($result) {
            $this->model = $result;
        }
        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Create many
     * @param array $attributes
     * @return mixed
     */
    public function createMany(array $arrayAttributes)
    {
        return $this->model->insert($arrayAttributes);
    }

    /**
     * Save (to use on Eloquent Model)
     * @param array $attributes
     * @return mixed
     */
    public function save(array $attributes = [])
    {
        $this->model->fill($attributes);
        if ($this->model->save()) {
            return $this->model;
        }
        return false;
    }

    /**
     * Update
     * @param $model
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($model, array $attributes)
    {
        $result = $this->cast($model);
        if ($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
    }

    /**
     * Delete
     *
     * @param $model
     * @return bool
     * @throws \Exception
     */
    public function delete($model)
    {
        $result = $this->cast($model);
        if ($result) {
            $result->delete();
            return true;
        }
        return false;
    }

    /**
     * Make a new instance of the entity to query on.
     *
     * @param array $with
     * @return Builder|Model
     */
    public function make(array $with = [])
    {
        return $this->model->with($with);
    }

    /**
     * Return all results that have a required relationship.
     *
     * @param string $relation
     * @param array $with
     * @return Builder[]|Collection
     */
    public function has($relation, array $with = [])
    {
        $entity = $this->make($with);
        return $entity->has($relation)->get();
    }

    /**
     * Find a single entity by key value.
     *
     * @param string $key
     * @param string $value
     * @param array $with
     * @return Builder|Model|object|null
     */
    public function getFirstBy($key, $value, array $with = [])
    {
        return $this->make($with)->where($key, '=', $value)->first();
    }

    /**
     * Find many entities by key value.
     *
     * @param string $key
     * @param string $value
     * @param array $with
     * @return Builder[]|Collection
     */
    public function getManyBy($key, $value, array $with = [])
    {
        return $this->make($with)->where($key, '=', $value)->get();
    }

    /**
     * @return Model
     */
    public function originalModel()
    {
        return new $this->model;
    }

    /**
     * Cast the parameter to Model
     * @param  mixed $model the parameter
     * @return Model
     */
    protected function cast($model)
    {
        if ($model instanceof Model) {
            return $model;
        } elseif ($this->model->id == $model) {
            return $this->model;
        } else {
            return $this->find($model);
        }
    }
}
