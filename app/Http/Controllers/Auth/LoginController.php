<?php

namespace App\Http\Controllers\Auth;

use App\Services\User\LoginService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function login(
        LoginRequest $request,
        LoginService $loginSrv
    ) {
        try {
            if (!empty($request->errors)) {
                return $request->throwValidationException();
            } else {
                $result = $loginSrv->handle($request->validated());
                if ($result['type'] != $loginSrv::SUCCESS) {
                    return res(500, $result);
                }

                return res(200, $result);
            }
        } catch (\Exception $e) {
            return serverError($e);
        }
    }
}
