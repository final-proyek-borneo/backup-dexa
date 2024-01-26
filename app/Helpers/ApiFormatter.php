<?php

namespace App\Helpers;

class ApiFormatter
{
    protected static $response =  [
        'code' =>  null,
        'message' => null,
        'data' => null,
    ];

    public static function createApi($code = null, $message = null, $data = null)
    {
        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['code']);
    }

    public static function getResponse($data = null)
    {
        if(!empty($data) || count($data)){
            return [
                'status' => 200,
                'data' => $data,
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Data tidak ditemukan'
            ];
        }
    }
}
