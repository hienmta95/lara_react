<?php

namespace App\Repositories\User;

use App\Repositories\EloquentRepository;
use App\Models\User;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getList($limit = 10, $sortBy = 'desc')
    {
        return 'test';
    }

    public function findLoginUser($param)
    {
        return $this->model->where('email', $param['email'])
            ->isVerified()
            ->first();
    }
}
