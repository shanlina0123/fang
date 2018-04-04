<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Service\Admin\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/***
 * 角色管理
 * Class RolesController
 * @package App\Http\Controllers\Admin
 */
class RolesController extends AdminBaseController
{
    public  $roles;
    public  $request;
    public function __construct(Request $request, Roles $roles)
    {
        $this->request = $request;
        $this->roles = $roles;
    }

    /***
     * 获取角色列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function  index()
    {
        //获取业务数据
        $list=$this->roles->index();
        //接口返回结果
         responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

    /***
     * 角色详情
     */
    public function edit($uuid)
    {
        //验证规则
        $validator = Validator::make(["uuid"=>$uuid],[
                'uuid' => 'required|max:32|min:32'
        ],['uuid.required'=>'参数错误','uuid.max'=>'参数错误','uuid.min'=>'参数错误']);

        //进行验证
        if ($validator->fails()) {
             responseData(\StatusCode::PARAM_ERROR,"参数错误");
        }
        //获取业务数据
        $data=$this->roles->edit($uuid);
        //接口返回结果
         responseData(\StatusCode::SUCCESS,"获取成功",$data);
    }

}