<?php


namespace App\Helpers;


class ResponseFormatHelper
{

    /**
     * @param array $data
     * @param $message
     * @return array
     */
    public static function responseFormat(bool $success, array $data = null, $message = null): array
    {
        return [
            'success' => $success,
            'data' => $data,
            'message' => $message,
        ];
    }
}
