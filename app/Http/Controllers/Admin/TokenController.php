<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;

/***
 * 验证token 这个接口放到 token验证后
 * Class TokenController
 * @package App\Http\Controllers\Home
 */
class TokenController extends AdminBaseController
{
    /***
     * 检查已有token,中间件会过滤
     */
    public function  index()
    {
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"检测成功");
    }

}