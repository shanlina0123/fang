<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Home;
use App\Service\Home\ConfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/***
 * 手机端web端配置
 * Class ConfController
 * @package App\Http\Controllers\Home
 */
class ConfController extends HomeBaseController
{
    public  $conf_service;
    public  $request;
    public function __construct(Request $request, ConfService $conf)
    {
        $this->request = $request;
        $this->conf_service = $conf;
    }


    /***
     * 获取数据源列表 所有
     */
    public function  index()
    {
        //获取业务数据
        $list=$this->conf_service->index();
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

}