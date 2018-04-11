<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Service\Admin\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/***
 * 用户管理
 * Class AdminController
 * @package App\Http\Controllers\Admin
 */
class AdminController extends AdminBaseController
{
    public  $admin_service;
    public  $request;
    public function __construct(Request $request, AdminService $admin)
    {
        $this->request = $request;
        $this->admin_service = $admin;
    }

    /***
     * 获取用户列表
     */
    public function  index()
    {
        //获取业务数据
        $list=$this->admin_service->index();
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

    /***
     * 用户详情
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
        $data=$this->admin_service->edit($uuid);
        //接口返回结果
         responseData(\StatusCode::SUCCESS,"获取成功",$data);
    }


    /***
     * 新增用户 - 执行
     * 测试：
     * password=base64:  123456=MTIzNDU2
     * uuid=90dabbc63afd11e8a35594de807e34a0
     */
    public  function  store()
    {
        //获取请求参数
        $data=$this->getData(["nickname","name","mobile","password","roleid"],$this->request->all());
        //验证规则
        $validator = Validator::make($data,[
            "nickname"=>'required|max:100|min:1',
            "name"=>'required|max:100|min:1',
            "mobile"=>'required|max:11|min:11',
            'password' => 'required',
            'roleid' => 'required|numeric',
        ],['nickname.required'=>'姓名不能为空','nickname.max'=>'姓名长度不能大于100个字符','nickname.min'=>'姓名长度不能小于1个字符',
            'name.required'=>'账号不能为空','name.max'=>'账号长度不能大于100个字符','name.min'=>'账号长度不能小于1个字符',
            'mobile.required'=>'手机号不能为空','mobile.max'=>'手机号不能大于11位字符','mobile.min'=>'手机号不能少于11位字符',
            'password.required'=>'密码不能为空',
            'roleid.required'=>'角色不能为空','roleid.numeric'=>'角色只能是数字格式']);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //密码base_decode验证
        if(checkStringIsBase64($data["password"]))
        {
            $data["password"]= base64_decode($data["password"]);
        }else{
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",["password"=>["密码格式非预定义"]]);
        }
       //密码长度验证
        if(strlen($data["password"])<6 || strlen($data["password"])>18)
        {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",["password"=>["密码格式6到18位字符之间"]]);
        }

        //执行业务处理
         $this->admin_service->store($data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"新增成功");
    }


    /***
     * 修改用户 - 执行
     * base64: 123456=MTIzNDU2Nw==
     */
    public  function  update($uuid)
    {
        //获取请求参数
        $data=$this->getData(["name","mobile","password","roleid"],$this->request->all());
        //拼接验证数据集
        $validateData=array_merge(["uuid"=>$uuid],$data);

        //定义验证规则
        $validator = Validator::make($validateData,[
            'uuid' => 'required|max:32|min:32',
            "name"=>'required|max:100|min:1',
            "mobile"=>'required|max:11|min:11',
            'password' => 'required',
            'roleid' => 'required|numeric',
        ],['uuid.required'=>'参数错误','uuid.max'=>'参数错误','uuid.min'=>'参数错误',
            'name.required'=>'账号不能为空','name.max'=>'账号长度不能大于100个字符','name.min'=>'账号长度不能小于1个字符',
            'mobile.required'=>'手机号不能为空','mobile.max'=>'手机号不能大于11位字符','mobile.min'=>'手机号不能少于11位字符',
            'password.required'=>'密码不能为空',
            'roleid.required'=>'角色不能为空','roleid.numeric'=>'角色只能是数字格式']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //获取业务数据
        $this->admin_service->update($uuid,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"修改成功");
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
        $this->admin_service->setting($uuid);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"设置成功");
    }


}