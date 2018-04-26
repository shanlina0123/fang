<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Service\Admin\DatasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/***
 * 自定义属性管理 +默认属性列表
 * Class RolesController
 * @package App\Http\Controllers\Admin
 */
class DatasController extends AdminBaseController
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


    /**
     * 获取数据源列表
     */
    public function getall()
    {
        //获取业务数据
        $list = $this->datas_service->getall();
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
             responseData(\StatusCode::PARAM_ERROR,"验证失败");
        }
        //获取业务数据
        $data=$this->datas_service->edit($uuid);
        //接口返回结果
         responseData(\StatusCode::SUCCESS,"获取成功",$data);
    }


    /***
     * 新增数据源 - 执行
     */
    public  function  store()
    {
        //获取请求参数
        $data=$this->getData(["cateid","name"],$this->request->all());
        //验证规则
        $validator = Validator::make($data,[
            'cateid' => 'required|numeric',
            "name"=>'required|max:100|min:1',
        ],['cateid.required'=>'参数cateid错误','cateid.numeric'=>'参数cateid格式必须int',
            'name.required'=>'名称不能为空','name.max'=>'名称长度不能大于100个字符','name.min'=>'名称长度不能小于1个字符']);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //执行业务处理
        $data= $this->datas_service->store($data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"新增成功",$data);
    }


    /***
     * 修改数据源 - 执行
     */
    public  function  update($uuid)
    {
        //获取请求参数
        $data=$this->getData(["name","cateid"],$this->request->all());
        //拼接验证数据集
        $validateData=array_merge(["uuid"=>$uuid],$data);

        //定义验证规则
        $validator = Validator::make($validateData,[
            'uuid' => 'required|max:32|min:32',
            'cateid' => 'required|numeric',
            "name"=>'required|max:100|min:1',
        ],['uuid.required'=>'参数错误','uuid.max'=>'参数错误','uuid.min'=>'参数错误',
            'cateid.required'=>'参数cateid错误','cateid.numeric'=>'参数cateid格式必须int',
            'name.required'=>'名称不能为空','name.max'=>'名称长度不能大于100个字符','name.min'=>'名称长度不能小于1个字符']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //获取业务数据
        $this->datas_service->update($uuid,$data);

        //接口返回结果
        responseData(\StatusCode::SUCCESS,"修改成功");
    }

    /***
     * 删除
     */
    public function  delete($uuid)
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
        $this->datas_service->delete($uuid);

        //接口返回结果
        responseData(\StatusCode::SUCCESS,"删除成功");
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
        $this->datas_service->setting($uuid);

        //接口返回结果
        responseData(\StatusCode::SUCCESS,"设置成功");
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

    /***
     * 获取自定义分类列表
     */
    public function  cateList()
    {
        //获取业务数据
        $list=$this->datas_service->cateList();
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

}