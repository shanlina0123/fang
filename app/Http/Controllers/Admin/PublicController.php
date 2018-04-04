<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;

class PublicController extends AdminBaseController
{

    /**
     * 上传图片到本地临时目录
     */
    public function uploadImgToTemp(Request $request)
    {
        if( $request->file('file') == false ) return '';
        try {
            $res = $request->file('file')->store('temp', 'temp');
            $name = explode('/',$res)[1];
            $src = new \stdClass();
            $src->src = "http://".$_SERVER['HTTP_HOST'].'/temp/'.$name;
            $src->name = $name;
            responseData(\StatusCode::SUCCESS,'上传成功',$src);
        } catch (Exception $e)
        {
            responseData(\StatusCode::ERROR,'上传失败');
        }
    }
}
