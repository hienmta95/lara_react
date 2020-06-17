<?php

if (!function_exists('res')) {
    function res($code = 200, $message = '', $data = [])
    {
        if (is_array($message)) {
            $data = $message['data'];
            $message = $message['message'];
        }
        return response()->json(
            [
            'success' => in_array($code, [200, 201]) ? true : false,
            'code' => $code,
            'message' => $message,
            'data' => $data
            ],
            200
        );
    }
}

if (!function_exists('serverError')) {
    function serverError($ex)
    {
        return res(500, $ex->getMessage() ?? $ex);
    }
}
