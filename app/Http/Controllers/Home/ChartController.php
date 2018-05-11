<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Home;
use App\Service\Home\ChartService;
use Illuminate\Http\Request;

/***
 * 数据整理
 * Class HomeController
 * @package App\Http\Controllers\Home
 */
class ChartController extends HomeBaseController
{
    public  $chart_service;
    public  $request;
    public function __construct(Request $request, ChartService $chart)
    {
        $this->request = $request;
        $this->chart_service = $chart;
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



}