<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Service\Admin\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class HouseController extends AdminBaseController
{
    public  $house;
    public  $request;
    public function __construct(Request $request, House $house)
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

    public function store()
    {
        $data = trimValue( $this->request->all() );
        //验证
        $validator = Validator::make(
            $data,
            $this->house->getRules(),
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