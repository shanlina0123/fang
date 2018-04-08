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
use Illuminate\Support\Facades\Validator;

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
        //获取业务数据
        $list=$this->chart_service->index();
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

}