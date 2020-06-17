<?php

namespace App\Services\Post;

use App\Services\BaseService;
use App\Repositories\Post\PostRepositoryInterface;

class PostService extends BaseService
{
    private $repository;

    public function __construct(PostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getMany($params)
    {
        $data = $this->repository->getAll();
        return $this->responseSuccess('Get list ok.', $data);
    }

    public function createOne($params)
    {
        $data = $this->repository->create($params);
        if (!empty($data)) {
            return $this->responseSuccess('Create post ok.', $data);
        }
        return $this->responseFailed();
    }

    public function getOne($params)
    {
        $data = $this->repository->find($params['id']);
        if (empty($data)) {
            return $this->responseFailed('Post not found.');
        }
        return $this->responseSuccess('', $data);
    }

    public function updateOne($id, $params)
    {
        $data = $this->repository->update($id, $params);
        if ($data) {
            return $this->responseSuccess('', $data);
        }
        return $this->responseFailed();
    }

    public function deleteOne($id)
    {
        $data = $this->repository->delete($id);
        if ($data) {
            return $this->responseSuccess('', $data);
        }
        return $this->responseFailed();
    }
}
