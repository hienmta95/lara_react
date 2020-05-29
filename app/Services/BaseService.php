<?php

namespace App\Services;

class BaseService
{
    const ERROR = 0;
    const SUCCESS = 1;

    /**
     * @param $message
     * @param int $type
     * @return array
     */
    protected function responseStatus($message, $type = self::ERROR, $data = [])
    {
        return [
            'type' => $type,
            'message' => $message,
            'data' => $data
        ];
    }
}
