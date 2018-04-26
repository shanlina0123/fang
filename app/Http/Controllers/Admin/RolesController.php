<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Service\Admin\RolesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/***
 * 角色管理
 * Class RolesController
 * @package App\Http\Controllers\Admin
 */
class RolesController extends AdminBaseController
{
    public  $roles_service;
    public  $request;
    public function __construct(Request $request, RolesService $roles)
    {
        $this->request = $request;
        $this->roles_service = $roles;
    }

    /***
     * 获取角色列表
     */
    public function  index()
    {
        //获取业务数据
        $list=$this->roles_service->index();
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

    /***
     * 获取角色列表
     */
    public function  roleList()
    {
        //获取业务数据
        $list=$this->roles_service->index();
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

    /***
     * 角色详情
     * @param $uuid
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
        $data=$this->roles_service->edit($uuid);
        //接口返回结果
         responseData(\StatusCode::SUCCESS,"获取成功",$data);
    }


    /***
     * 新增角色 - 执行
     */
    public  function  store()
    {
        //获取请求参数
        $data=$this->getData(["name"],$this->request->all());
        //验证规则
        $validator = Validator::make($data,[
            "name"=>'required|max:100|min:1',
        ],['name.required'=>'名称不能为空','name.max'=>'名称长度不能大于100个字符','name.min'=>'名称长度不能小于1个字符']);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //执行业务处理
         $this->roles_service->store($data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"新增成功");
    }


    /***
     * 修改角色 - 执行
     */
    public  function  update($uuid)
    {
        //获取请求参数
        $data=$this->getData(["name"],$this->request->all());
        //拼接验证数据集
        $validateData=array_merge(["uuid"=>$uuid],$data);

        //定义验证规则
        $validator = Validator::make($validateData,[
            'uuid' => 'required|max:32|min:32',
            "name"=>'required|max:100|min:1',
        ],['uuid.required'=>'参数错误','uuid.max'=>'参数错误','uuid.min'=>'参数错误',
            'name.required'=>'名称不能为空','name.max'=>'名称长度不能大于100个字符','name.min'=>'名称长度不能小于1个字符']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //获取业务数据
        $this->roles_service->update($uuid,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"修改成功");
    }


    /***
     * 删除角色
     */
    public function  delete($uuid)
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
        $this->roles_service->delete($uuid);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"删除成功");
    }


}