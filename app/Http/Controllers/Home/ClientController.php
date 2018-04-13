<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Home;
use App\Service\Home\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/***
 * 客户端配置
 * Class ConfController
 * @package App\Http\Controllers\Home
 */
class ClientController extends HomeBaseController
{
    public  $client_service;
    public  $request;
    public function __construct(Request $request, ClientService $client)
    {
        $this->request = $request;
        $this->client_service = $client;
    }


    /***
     * 获取我的客户列表
     */
    public function  index()
    {
        //获取请求参数
        $data=$this->getData(["name","followstatusid"],$this->request->all());
        //验证规则
        $validator = Validator::make($data,[
            "name"=>'present|max:100|min:1',
            "followstatusid"=>'present|numeric',
        ],[ 'name.present'=>'名称参数缺少','name.max'=>'名称长度不能大于100个字符','name.min'=>'名称长度不能小于1个字符',
            'followstatusid.present'=>'状态参数缺少','followstatusid.numeric'=>'状态只能是int类型',]);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //获取请求页码
        $page=$this->request->input("page");

        //获取当前登录用户信息
        $userinfo=$this->request->get("userinfo");//对象

        $list=$this->client_service->index($userinfo->id,$userinfo->adminid,$data,$page);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

    /****
     * 获取房源列表--推荐房源时候模糊搜索的下拉框内容
     */
    public  function  houseData()
    {
        //获取请求参数
        $data=$this->getData(["name"],$this->request->all());
        //验证规则
        $validator = Validator::make($data,[
            "name"=>'present|max:100|min:1',
        ],[ 'name.required'=>'账号参数缺少','name.max'=>'账号长度不能大于100个字符','name.min'=>'账号长度不能小于1个字符']);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }

        //获取业务数据
        $list=$this->client_service->houseData($data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

    /***
     * 获取我推荐的客户量统计
     */
    public function  statistics()
    {
        //获取当前登录用户信息
        $userinfo=$this->request->get("userinfo");//对象
        //获取业务数据
        $list=$this->client_service->statistics($userinfo->id);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

    /***
     * 推荐客户
     *
     */
    public  function  store()
    {
        //获取请求参数
        $data=$this->getData(["name","mobile","houseid","companyid","remark"],$this->request->all());
        //验证规则
        $validator = Validator::make($data,[
            "name"=>'required|max:100|min:1',
            "mobile"=>'required|max:11|min:11',
            "houseid"=>'required|numeric',
            'companyid' => 'present',
            'remark' => 'present',
        ],[ 'name.required'=>'账号不能为空','name.max'=>'账号长度不能大于100个字符','name.min'=>'账号长度不能小于1个字符',
            'mobile.required'=>'手机号不能为空','mobile.max'=>'手机号不能大于11位字符','mobile.min'=>'手机号不能少于11位字符',
            'houseid.required'=>'楼盘id不能为空','houseid.numeric'=>'楼盘id只能是int类型',
            'companyid.present'=>'公司id参数缺少',
            'remark.present'=>'备注参数缺少']);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //获取当前登录用户信息
        $userinfo=$this->request->get("userinfo");//对象

        //判断是否内部员工
        if($userinfo->isadminafter==1)
        {
            $data["companyid"]=1;//内部员工
        }else{
            if(empty( $data["companyid"]))
            {
                responseData(\StatusCode::PARAM_ERROR,"验证失败","",["companyid",["非内部员工，公司id不能为空"]]);
            }
        }

        //执行业务处理
        $this->client_service->store($userinfo->adminid,$userinfo->id,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"推荐成功");
    }

}