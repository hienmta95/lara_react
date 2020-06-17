<?php

namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getList($limit = 10, $sortBy = 'desc');

    public function findLoginUser($param);
}
