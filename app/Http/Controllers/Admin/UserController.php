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
    public $mod;
    public $request;

    public function __construct(Request $request, UserService $mod)
    {
        $this->mod = $mod;
        $this->request = $request;
    }


    /**
     * 经纪人列表
     */
    public function broker()
    {
        $res = $this->mod->getList($this->request);
        responseData(\StatusCode::SUCCESS, '经纪人列表', $res);
    }


    /***
     * 禁用/启用
     */
    public function  setting($uuid)
    {
        //定义验证规则
        $validator = Validator::make(["uuid"=>$uuid],[
            'uuid' => 'required|max:32|min:32',
        ],['uuid.required'=>'参数错误','uuid.max'=>'参数错误','uuid.min'=>'参数错误']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"参数错误");
        }
        //获取业务数据
        $this->mod->setting($uuid);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"设置成功");
    }



}