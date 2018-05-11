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
        if(strlen($data["followstatusid"])>0&&$data["followstatusid"]==0)
        {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",["followstatusid"=>["客户状态值不能为空"]]);
        }
        //获取请求页码
        $page=$this->request->input("page");

        //获取当前登录用户信息
        $userinfo=$this->request->get("userinfo");//对象

        $list=$this->client_service->index($userinfo->id,$userinfo->isadminafter,$userinfo->adminid,$data,$page);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

    /****
     * 获取房源列表--推荐房源时候模糊搜索的下拉框内容
     */
    public  function  houseData()
    {
        //获取请求参数
        $data=$this->getData(["name","typeid","uuid"],$this->request->all());
        //验证规则
        $validator = Validator::make($data,[
            "name"=>'present|max:100|min:1',
            "typeid"=>'present|numeric',
            "uuid"=>'present|max:32|min:32',
        ],[ 'name.present'=>'账号参数缺少','name.max'=>'账号长度不能大于100个字符','name.min'=>'账号长度不能小于1个字符',
            'typeid.present'=>'房源类型参数缺少','typeid.numeric'=>'房源类型只能是int类型',
            'uuid.present'=>'uuid参数缺少','uuid.max'=>'uuid长度不能大于32个字符','uuid.min'=>'uuid长度不能小于32个字符',]);
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
        $data=$this->getData(["name","mobile","houseid","companyid","remark","isappoint","adminid"],$this->request->all());
        //验证规则
        $validator = Validator::make($data,[
            "name"=>'required|max:100|min:1',
            "mobile"=>'required|max:11|min:11',
            "houseid"=>'required|numeric',
            'companyid' => 'present|numeric',
            'remark' => 'present',
            'isappoint' =>'required|numeric',
            'adminid' => 'required|numeric',
        ],[ 'name.required'=>'账号不能为空','name.max'=>'账号长度不能大于100个字符','name.min'=>'账号长度不能小于1个字符',
            'mobile.required'=>'手机号不能为空','mobile.max'=>'手机号不能大于11位字符','mobile.min'=>'手机号不能少于11位字符',
            'houseid.required'=>'楼盘id不能为空','houseid.numeric'=>'楼盘id只能是int类型',
            'companyid.present'=>'公司id参数缺少','companyid.numeric'=>'公司id只能是int类型',
            'remark.present'=>'备注参数缺少',
            'isappoint.required'=>'指定id不能为空','isappoint.numeric'=>'指定id只能是int类型',
            'adminid.required'=>'业务员id不能为空','adminid.numeric'=>'业务员id只能是int类型']);
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
            $data["remark"]="公司内部员工推荐";
        }else{
            if(empty( $data["companyid"]))
            {
                responseData(\StatusCode::PARAM_ERROR,"验证失败","",["companyid",["非内部员工，公司id不能为空"]]);
            }
        }

        //判断是否指定值
        if(!in_array($data["isappoint"],[0,1]))
        {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",["companyid",["指定值不符合预定义"]]);
        }
        //未指定，设置adminid=0
        if($data["isappoint"]==0)
        {
            $data["adminid"]=0;
        }
        //已指定，判定adminid是否有值
        if($data["isappoint"]==1&&$data["adminid"]==0)
        {
            responseData(\StatusCode::PARAM_ERROR,"未选择指定业务员","",["adminid",["未选择指定业务员"]]);
        }


        //执行业务处理
        $this->client_service->store($userinfo->adminid,$userinfo->id,$userinfo,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"推荐成功");
    }

    /***
     * 修改客户级别和状态
     */
    public  function  update($uuid)
    {
        //获取请求参数
        $data=$this->getData(["levelid","followstatusid"],$this->request->all());
        //拼接验证数据集
        $validateData=array_merge(["uuid"=>$uuid],$data);
        //定义验证规则
        $validator = Validator::make($validateData,[
            'uuid' => 'required|max:32|min:32',
            "levelid"=>'present|numeric',
            "followstatusid"=>'present|numeric'
        ],['uuid.required'=>'参数错误','uuid.max'=>'参数错误','uuid.min'=>'参数错误',
            'levelid.present'=>'级别id参数缺少','levelid.numeric'=>'级别只能是int类型',
            'followstatusid.present'=>'客户状态id参数缺少','followstatusid.numeric'=>'客户状态id只能是int类型'
          ]);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //至少一项不为空
        if(empty($data["levelid"])&&empty($data["followstatusid"]))
        {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",["levelid"=>["客户级别和客户状态至少一项不为空"],"followstatusid"=>["客户级别和客户状态至少一项不为空"]]);
        }
        //获取当前登录用户信息
        $userinfo=$this->request->get("userinfo");//对象

        //获取业务数据
        $this->client_service->update($uuid,$userinfo->id,$userinfo->adminid,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"修改成功");
    }
}