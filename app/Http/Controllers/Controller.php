<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    /**
     * 返回信息
     */
    public function responseData( $data )
    {
        $res = new \stdClass();
        $res->status = $data['status'];
        $res->messages = $data['messages'];
        $res->data = $data['data'];
        return response()->json($res,200);
    }
}
