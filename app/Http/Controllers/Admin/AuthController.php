<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Service\Admin\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/***
 * 权限管理
 * Class AuthController
 * @package App\Http\Controllers\Admin
 */
class AuthController extends AdminBaseController
{
    public  $auth_service;
    public  $request;
    public function __construct(Request $request, AuthService $auth_service)
    {
        $this->request = $request;
        $this->auth_service = $auth_service;
    }

    /***
     * 获取权限功能列表
     */
    public function  index()
    {
        //获取业务数据
        $list=$this->auth_service->index();
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

    /***
     * 角色权限详情
     * @param $uuid
     */
    public function edit($role_uuid)
    {
        //验证规则
        $validator = Validator::make(["role_uuid"=>$role_uuid],[
            'role_uuid' => 'required|max:32|min:32'
        ],['role_uuid.required'=>'参数为空错误','role_uuid.max'=>'参数max错误','role_uuid.min'=>'参数min错误',]);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //获取业务数据
        $data=$this->auth_service->edit($role_uuid);
        //接口返回结果
         responseData(\StatusCode::SUCCESS,"获取成功",$data);
    }



    /***
     * 勾选角色权限 - 执行
     */
    public  function  update($role_uuid)
    {
        //获取请求参数
        $data=$this->getData(["functionid"],$this->request->all());
        $validateData=array_merge(["role_uuid"=>$role_uuid],$data);

        //定义验证规则
        $validator = Validator::make($validateData,[
            'role_uuid' => 'required|max:32|min:32',
            "functionid"=>'required',
        ],['role_uuid.required'=>'uuid参数为空错误','role_uuid.max'=>'uuid参数max错误','role_uuid.min'=>'uuid参数min错误',
            'functionid.required'=>'functionid参数为空错误']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }

        //数组 int验证 updateorcreate
        if(!checkParam($data["functionid"],"is_array_int"))
        {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",["functionid"=>["functionid参数格式错误"]]);
        }

        //获取业务数据
        $this->auth_service->update($role_uuid,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"设置成功");
    }




}