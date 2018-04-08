<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    /***
     * 获取请求参数
     * @param $initKeys
     * @param $data
     * @return array
     */
    public function  getData($initKeys,$data)
    {
        $data=trimValue($data);//去空格
        $postKeys=array_keys($data);//请求的keys
        $unsetKeys=array_diff($postKeys,$initKeys);//未定义多余的keys
        //移除非定义的参数
        foreach($unsetKeys as $k=>$v)
        {
            unset($data[$v]);
        }
        //返回结果
        return $data;

    }

}
