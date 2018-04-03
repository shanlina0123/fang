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
     * @param $type
     * 添加房源返回表单自定数据
     */
    public function create()
    {
        $res = $this->house->getSelect();
        return $this->responseData($res);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 添加房源
     */
    public function store()
    {
        $data = trimValue( $this->request->all() );
        //公用验证规则
        $rulesPublic = $this->house->getRules();
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
            $messages = $validator->errors()->first();
            return $this->responseData(['status'=>\StatusCode::CHECK_FROM,'messages'=>'验证失败','data'=>$messages]);
        }
        $res = $this->house->storeHouse( $data );
        return $this->responseData($res);
    }
}