<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;

class TestController extends AdminBaseController
{
    /**
     * curl测试
     */
    public function index()
    {
        $url = 'http://fang.com/api/admin/house/update/c1df6edc8486d10673cc7220172ee91f';
        $header = array(
            'Authorization' => 'DX7zI7MWLDII6Jc0LeMRGvf5St9hH6irqA6IiFgW2AkTd3GYYzQtSLTzmzX5'
        );
        $post = array(
                'name'=>'金色悦城04',
                'iscommission'=>1,
                'commissionid'=>1,
                'ishome'=>1,
                'provinceid'=>1,
                'cityid'=>1,
                'street'=>'龙首街道',
                'addr'=>'印象城',
                'fulladdr'=>'西安市龙首村印象城',
                'floorpostionid'=>2,
                'floor'=>'30/31',
                'orientationid'=>2,
                'purposeid'=>2,
                'area'=>20.66,
                'created_at'=>date("Y-m-d H:i:s"),
                'iselevator'=>1,
                'years'=>'2015年',
                'decoratestyleid'=>1,
                'ownershipid'=>1,
                'hasdoublegasid'=>1,
                'propertyfee'=>150,
                'lng'=>'108.9470100000',
                'lat'=>'34.2928300000',
                //新房
                'typeid'=>1,
                'salestatusid'=>1,
                'opendate'=>date("Y-m-d H:i:s"),
                'price'=>6700,
                'roomtypeid'=>1,
                'status'=>1,
                'tagid'=>[1,2,3]
                //二手
//                'typeid'=>2,
//                'price'=>6700,
//                'total'=>80,
//                'roomtypeid'=>3,
               //商铺
//                'typeid'=>3,
//                'total'=>100,
//                'depth'=>60,
//                'storey'=>'3米',
//                'wide'=>'20米',
        );
        $curl = new \CurlFunction();
        $res = $curl->curlOpen($url,array('post'=>$post,'header'=>$header));
        dd( $res );
    }
}
