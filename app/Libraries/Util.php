<?php
namespace App\Libraries;

class Util
{
    public static function responseJson($status, $code, $message = '', $data = [])
    {
        return response()->json(
            [
                'code'      => $code,
                'message'   => $message,
                'data'      => $data,
            ],
            $status,
            [
                'Content-Type'  => 'application/json;charset=UTF-8',
                'Charset'       => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE
        );
    }
}