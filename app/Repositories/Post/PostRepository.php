<?php

namespace App\Repositories\Post;

use App\Repositories\EloquentRepository;
use App\Models\Post;

class PostRepository extends EloquentRepository implements PostRepositoryInterface
{
    public function getModel()
    {
        return Post::class;
    }

    public function getAll($sortBy = 'DESC')
    {
        return $this->model->with(['category'])
            ->orderBy('id', $sortBy)
            ->get();
    }

}
