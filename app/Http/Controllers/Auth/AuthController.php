<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\User\LoginService;
use App\Services\User\RegisterService;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function register(
        RegisterRequest $request,
        RegisterService $registerSrv
    ) {
        try {
            DB::beginTransaction();
            if (!empty($request->errors)) {
                return $request->throwValidationException();
            } else {
                $result = $registerSrv->handle($request->validated());
                if ($result['type'] != $registerSrv::SUCCESS) {
                    DB::rollback();
                    return res(500, $result);
                }

                DB::commit();
                return res(200, $result);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return serverError($e);
        }
    }

    public function login(
        LoginRequest $request,
        LoginService $loginSrv
    ) {
        try {
            if (!empty($request->errors)) {
                return $request->throwValidationException();
            } else {
                $result = $loginSrv->handle($request);
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
