<?php

namespace App\Repositories\Category;

use App\Repositories\EloquentRepository;
use App\Models\Category;

class CategoryRepository extends EloquentRepository implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return Category::class;
    }

    public function getAll($sortBy = 'DESC')
    {
        return $this->model->with(['posts'])
            ->orderBy('id', $sortBy)
            ->get();
    }

}
