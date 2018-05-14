<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Service\Admin\ChartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
/***
 * 数据分析管理
 * Class AdminController
 * @package App\Http\Controllers\Admin
 */
class ChartController extends AdminBaseController
{
    public  $chart_service;
    public  $request;
    public function __construct(Request $request, ChartService $chart)
    {
        $this->request = $request;
        $this->chart_service = $chart;
    }

    /***
     * 获取客户数据分析列表
     */
    public function  index()
    {
        //获取请求参数
        $data=$this->getData(["isexcel","followstatusid","companyid","ownadminid","refereeuserid","makedate","comedate","dealdate"],$this->request->all());
        //验证规则
        $validator = Validator::make($data,[
            "isexcel"=>'present|numeric',
            "followstatusid"=>'present|numeric',
            "companyid"=>'present|numeric',
            "ownadminid"=>'present|numeric',
            "refereeuserid"=>'present|numeric',
        ],[ 'isexcel.present'=>'导出态参数缺少','isexcel.numeric'=>'导出只能是int类型',
            'followstatusid.present'=>'客户状态参数缺少','name.numeric'=>'客户状态只能是int类型',
            'companyid.present'=>'公司参数缺少','companyid.numeric'=>'公司只能是int类型',
            'ownadminid.present'=>'业务员参数缺少','ownadminid.numeric'=>'业务员只能是int类型',
            'refereeuserid.present'=>'经纪人参数缺少','refereeuserid.numeric'=>'经纪人只能是int类型']);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }

        if(!in_array($data["isexcel"],[0,1]))
        {
            responseData(\StatusCode::PARAM_ERROR,"导出值不符合预定义","",$validator->errors());
        }
        //获取请求页码
        $page=$this->request->input("page");

        if($data["isexcel"]==0)
        {
            //获取业务数据
            $list=$this->chart_service->index($data,$page);
        }else{
            $list=$this->chart_service->excellist($data);
        }
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);

    }


   /*
   * 获取所有经纪人 下拉框
   */
    public function getUsers()
    {
        //获取业务数据
        $list = $this->chart_service->getUsers();
        //接口返回结果
        responseData(\StatusCode::SUCCESS, "获取成功", $list);
    }
    /*
      * 获取所有业务员 下拉框
      */
    public function getAdmins()
    {
        //获取业务数据
        $list = $this->chart_service->getAdmins();
        //接口返回结果
        responseData(\StatusCode::SUCCESS, "获取成功", $list);
    }

    //导出excel
    public function export($search){
        $this->chart_service->export($search);
    }

}