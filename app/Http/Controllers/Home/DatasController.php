<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Home;
use App\Service\Home\DatasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/***
 * 自定义属性管理 +默认属性列表
 * Class RolesController
 * @package App\Http\Controllers\Home
 */
class DatasController extends HomeBaseController
{
    public  $datas_service;
    public  $request;
    public function __construct(Request $request, DatasService $datas)
    {
        $this->request = $request;
        $this->datas_service = $datas;
    }


    /***
     * 获取数据源列表 所有
     */
    public function  index()
    {
        //获取业务数据
        $list=$this->datas_service->index();
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }


    /***
     * 获取数据源列表-具体分类对应
     */
    public function  getOne($cateid)
    {
        //验证规则
        $validator = Validator::make(["cateid"=>$cateid],[
            'cateid' => 'required|numeric'
        ],['cateid.required'=>'参数错误','cateid.numeric'=>'参数错误']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"参数错误");
        }
        //获取业务数据
        $list=$this->datas_service->getOne($cateid);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

    /***
     * 数据源详情
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
        $data=$this->datas_service->edit($uuid);
        //接口返回结果
         responseData(\StatusCode::SUCCESS,"获取成功",$data);
    }


    /***
     * 获取数据源列表-默认数据 所有
     */
    public function  getDefault()
    {
        //获取业务数据
        $list=$this->datas_service->getDefault();
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }


    /***
     * 获取数据源列表-默认数据 具体分类对应
     */
    public function  getDefaultOne($cateid)
    {
        //验证规则
        $validator = Validator::make(["cateid"=>$cateid],[
            'cateid' => 'required|numeric'
        ],['cateid.required'=>'参数错误','cateid.numeric'=>'参数错误']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"参数错误");
        }
        //获取业务数据
        $list=$this->datas_service->getDefaultOne($cateid);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }
}