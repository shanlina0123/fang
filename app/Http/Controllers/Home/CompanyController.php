<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Home;
use App\Service\Home\CompanyService;
use Illuminate\Http\Request;
/***
 * 客户端配置
 * Class ConfController
 * @package App\Http\Controllers\Home
 */
class CompanyController extends HomeBaseController
{
    public  $client_service;
    public  $company;
    public function __construct(Request $request, CompanyService $company )
    {
        $this->request = $request;
        $this->company = $company;
    }


    /***
     * 获取我的客户列表
     */
    public function  index()
    {
        $res = $this->company->index();
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$res);
    }
}