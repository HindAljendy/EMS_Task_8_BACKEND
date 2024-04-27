<?php

namespace App\Http\Traits;


trait ApiResponseTrait
{

    public function customeResponse($data, $message, $status) {
        $array = [
            'data'=>$data,
            'message'=>$message
        ];

        return response()->json($array, $status);
    }
}
