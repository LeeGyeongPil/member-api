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

    public static function returnValidation($data, $successMsg, $failMsg = '')
    {
        if (empty($data)) {
            return Util::responseJson(200, '9998', $failMsg ?: 'No Data');
        }

        if ($data === 0 && $failMsg) {
            return Util::responseJson(200, '2000', $failMsg);
        }

        if ($data === true) {
            return Util::responseJson(201, '0000', $successMsg);
        }

        if (is_string($data) || is_array($data) === false) {
            return Util::responseJson(500, '9999', $failMsg ?: $data);
        }

        return Util::responseJson(200, '0000', $successMsg, $data);
    }
}