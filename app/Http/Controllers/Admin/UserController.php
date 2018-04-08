<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Service\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends AdminBaseController
{
    public  $mod;
    public  $request;
    public function __construct(Request $request, UserService $mod)
    {
        $this->mod = $mod;
        $this->request = $request;
    }


    /**
     * 获取所有经纪人
     */
    public  function  index()
    {
        //获取业务数据
        $list=$this->mod->index();
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

}