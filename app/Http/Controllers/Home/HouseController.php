<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Home;
use App\Service\Home\HouseService;
use Illuminate\Http\Request;
class HouseController extends HomeBaseController
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
     * 房源推荐
     */
    public function recommend()
    {
        $res = $this->house->getRecommend();
        responseData(\StatusCode::SUCCESS,'房源推荐列表',$res);
    }

    /**
     * 房源详情
     */
    public function info( $id )
    {
        $res = $this->house->getInfo( $id );
        responseData(\StatusCode::SUCCESS,'房源详情',$res);
    }
}