<?php

namespace App\Services\Category;

use App\Services\BaseService;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryService extends BaseService
{
    private $repository;

    public function __construct(CategoryRepositoryInterface $repository)
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
            return $this->responseSuccess('Create category ok.', $data);
        }
        return $this->responseFailed();
    }

    public function getOne($params)
    {
        $data = $this->repository->find($params['id']);
        if (empty($data)) {
            return $this->responseFailed('Category not found.');
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
