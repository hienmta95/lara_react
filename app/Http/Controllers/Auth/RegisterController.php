<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\User\RegisterService;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
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
}
