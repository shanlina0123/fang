<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Home;
use App\Service\Home\UsersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/***
 * 用户管理
 * Class UsersController
 * @package App\Http\Controllers\Home
 */
class UsersController extends HomeBaseController
{
    public  $users_service;
    public  $request;
    public function __construct(Request $request, UsersService $users)
    {
        $this->request = $request;
        $this->users_service = $users;
    }


    /***
     * 获取用户信息
     */
    public function  index()
    {
        $userid=$this->request->get("userinfo")->id;//userid
        //获取业务数据
        $list=$this->users_service->index($userid);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }


    /***
     * 修改用户信息
     */

    public  function  update()
    {
        //获取请求参数
        $data=$this->getData(["mobile"],$this->request->all());

        //定义验证规则
        $validator = Validator::make($data,[
            'mobile' => 'required|regex:/^1[345789][0-9]{9}$/',
        ],['mobile.required'=>'手机号不能为空','mobile.max'=>'手机号不能大于11位字符','mobile.min'=>'手机号不能少于11位字符']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //获取当前登录用户信息
        $userinfo=$this->request->get("userinfo");//对象
        if(empty($userinfo))
        {
            responseData(\StatusCode::PARAM_ERROR,"用户信息获取失败","",$validator->errors());
        }
        $userinfo=$userinfo->toArray();
        //获取业务数据
        $this->users_service->update($userinfo,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"修改成功");
    }


}