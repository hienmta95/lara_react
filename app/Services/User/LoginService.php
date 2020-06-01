<?php

namespace App\Services\User;

use App\Services\BaseService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepositoryInterface;

class LoginService extends BaseService
{
    public function handle($request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = auth('api')->attempt($credentials)) {
            return $this->responseSuccess(
                'Login success.',
                [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth('api')->factory()->getTTL() * 60
                ]
            );
        }
        return $this->responseFailed('Login failed.');
    }
}
