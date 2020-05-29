<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private static function getToken($email, $password)
    {
        $token = null;
        try {
            if (!$token = JWTAuth::attempt(['email'=>$email, 'password'=>$password])) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'Password or email is invalid',
                    'token'=>$token
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Cannot create token',
            ]);
        }

        return $token;
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return res(500, 'Validation failed.', $validator->errors());
            }

            $payload = [
                'password'=>Hash::make($request->password),
                'email'=>$request->email,
                'name'=>$request->name,
            ];

            $user = new User($payload);
            if ($user->save()) {
                $user->sendEmailVerificationNotification();
                $response = ['success'=>true];
            } else {
                $response = ['success'=>false, 'data'=>'Register Failed'];
            }

            return response()->json($response, 201);
        } catch(\Exception $ex) {
            return serverError($ex);
        }
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->whereNotNull('email_verified_at')->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = self::getToken($request->email, $request->password);
            $response = ['success'=> true, 'token' => $token];
        } else {
            $response = ['success' => false, 'data' => 'Login failed.'];
        }

        return response()->json($response, 201);
    }

}
