<?php

namespace App\Services;

class BaseService
{
    const ERROR = 0;
    const SUCCESS = 1;

    /**
     * @param  $message
     * @param  int $type
     * @return array
     */
    protected function responseSuccess($message = '', $data = [])
    {
        return [
            'type' => self::SUCCESS,
            'message' => !empty($message) ? $message : 'Action success.',
            'data' => $data
        ];
    }

    protected function responseFailed($message = '', $data = [])
    {
        return [
            'type' => self::ERROR,
            'message' => !empty($message) ? $message : 'Action failed.',
            'data' => $data
        ];
    }
}
