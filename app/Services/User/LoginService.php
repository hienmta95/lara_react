<?php

namespace App\Services\User;

use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\User\UserRepositoryInterface;

class LoginService extends BaseService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle($request)
    {
        $user = $this->userRepository->findLoginUser($request);
        if ($user && Hash::check($request['password'], $user->password)) {
            $token = $this->getJwtToken($request);
            if (!empty($token)) {
                return $this->responseStatus(
                    'Login success.',
                    self::SUCCESS,
                    ['token' => $token]
                );
            }
        }
        return $this->responseStatus('Login failed.');
    }

    private function getJwtToken($param)
    {
        return JWTAuth::attempt(['email' => $param['email'], 'password' => $param['password']]) ?? '';
    }
}
