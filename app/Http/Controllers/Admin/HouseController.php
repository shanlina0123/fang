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
}