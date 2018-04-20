<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Service\Admin\HouseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class HouseController extends AdminBaseController
{
    public  $house;
    public  $request;
    public function __construct(Request $request, HouseService $house)
    {
        $this->request = $request;
        $this->house = $house;
    }


    /**
     * 房源列表
     */
    public function index()
    {
        $res = $this->house->getList( $this->request );
        responseData(\StatusCode::SUCCESS,'房源列表',$res);
    }
    /**
     * @param $type
     * 添加房源返回表单自定数据
     */
    public function create()
    {
        $res = $this->house->getSelect();
        responseData(\StatusCode::SUCCESS,'发布房源下拉列表数据',$res);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 添加房源基本信息
     */
    public function store()
    {
        $data = trimValue( $this->request->all() );
        //公用验证规则
        $rulesPublic = $this->house->getRules( $data );
        switch ( (int)$data['typeid'] )
        {
            case 1:
                //新房
                $rules = array_collapse( $rulesPublic, $this->house->getNewRules() );
                break;
            case 2:
                //二手
                $rules = array_collapse( $rulesPublic, $this->house->getSencodRules() );
                break;
            case 3:
                //商铺
                $rules = array_collapse( $rulesPublic, $this->house->getShopRules() );
                break;
        }
        //验证
        $validator = Validator::make(
            $data,
            $rules,
            $this->house->errorsMessages()
        );
        if ($validator->fails())
        {
            $messages = $validator->errors();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages);
        }
        $adminid = $this->request->get('admin_user')->id;
        $res = $this->house->storeHouse( $data, $adminid );
        responseData(\StatusCode::SUCCESS,'写入成功',$res);
    }


    /**
     * 发布房源标签
     */
    public function storeTag()
    {
        $data = trimValue( $this->request->all() );
        //验证
        $validator = Validator::make(
            $data,[
                'tagid'=>'required|array',
                'houseid'=>'required|numeric'
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages);
        }
        $res = $this->house->saveTag( $data );
        responseData(\StatusCode::SUCCESS,'写入成功',$res);
    }


    /**
     * 图片上传
     */
    public function storeImg()
    {
        $data = trimValue( $this->request->all() );
        //验证
        $validator = Validator::make(
            $data,[
                'covermap'=>'required',
                'images'=>'required|array',
                'status'=>'required',
                'houseid'=>'required|numeric',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages);
        }
        $res = $this->house->saveImg( $data );
        responseData(\StatusCode::SUCCESS,'写入成功',$res);
    }


    /**
     * @param $uuid
     * 修改页面
     */
    public function edit( $uuid )
    {
        $data['uuid'] = $uuid;
        //验证
        $validator = Validator::make(
            $data,[
                'uuid'=>'required|min:32|max:32',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages);
        }
        $res = $this->house->editHouse( $uuid );
        responseData(\StatusCode::SUCCESS,'房源信息',$res);
    }

    /**
     * @param $uuid
     * 删除房源
     */
    public function destroy( $uuid )
    {
        $data['uuid'] = $uuid;
        //验证
        $validator = Validator::make(
            $data,[
                'uuid'=>'required|min:32|max:32',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages);
        }
        $res = $this->house->destroyHouse( $uuid );
        responseData(\StatusCode::SUCCESS,'删除成功',$res);
    }

    /**
     * @param $uuid
     * 编辑保存
     */
    public function update( $uuid )
    {
        $data = trimValue( $this->request->all() );
        $data['uuid'] = $uuid;
        //公用验证规则
        $rulesPublic = $this->house->getRules();
        switch ( (int)$data['typeid'] )
        {
            case 1:
                //新房
                $rules = array_collapse( $rulesPublic, $this->house->getNewRules(), ['uuid'=>'required|mix:32|max:32'] );
                break;
            case 2:
                //二手
                $rules = array_collapse( $rulesPublic, $this->house->getSencodRules(), ['uuid'=>'required|mix:32|max:32'] );
                break;
            case 3:
                //商铺
                $rules = array_collapse( $rulesPublic, $this->house->getShopRules(), ['uuid'=>'required|mix:32|max:32'] );
                break;
        }
        //验证
        $validator = Validator::make(
            $data,
            $rules,
            $this->house->errorsMessages()
        );
        if ($validator->fails())
        {
            $messages = $validator->errors();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages);
        }
        $res = $this->house->updateHouse( $data );
        responseData(\StatusCode::SUCCESS,'编辑成功',$res);
    }

    /**
     * 房源推荐
     */
    public function recommend()
    {
        $data = trimValue( $this->request->all() );
        //验证
        $validator = Validator::make(
            $data,[
                'uuid'=>'required|min:32|max:32',
            ]
        );
        if ($validator->fails())
        {
            $messages = ['uuid'=>'uuid不合法'];
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages);
        }
        $res = $this->house->recommendHouse( $data );
        responseData(\StatusCode::SUCCESS,'删除成功',$res);
    }
}