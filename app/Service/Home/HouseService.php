<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Home;
use App\Model\House\House;
use App\Model\House\HouseHome;
use App\Service\HomeBase;
use Illuminate\Support\Facades\Cache;
class HouseService extends HomeBase
{
    /**
     * @param $request
     * @return mixed
     * 房源列表
     */
    public function getList( $request )
    {
        $tag = 'HomeHouseList';
        $where = $request->input('page').$request->input('typeid').$request->input('name').$request->input('roomtypeid');
        $where = base64_encode($where);
        $value = Cache::tags($tag)->remember( $tag.$where,config('configure.sCache'), function() use( $request ){
            //房屋类型
            $typeID = $request->input('typeid');
            //楼盘名称
            $name = $request->input('name');
            //房型
            $roomtypeid = $request->input('roomtypeid');
            $sql = House::where('status',1)->orderBy('id','desc');
            if(  $typeID )
            {
                $sql->where('typeid',$typeID);
            }
            if(  $roomtypeid )
            {
                $sql->where('roomtypeid',$roomtypeid);
            }
            if( $name )
            {
                $sql->where('name','like','%'.$name.'%');
            }
            return $sql->paginate(config('configure.sPage'));
        });
        return $value;
    }


    /**
     * @return mixed
     * 首页推荐
     */
    public function getRecommend()
    {
        $tag = 'HomeRecommend';
        $value = Cache::tags($tag)->remember( $tag,config('configure.sCache'), function(){
            $RecommendID = HouseHome::orderBy('id','desc')->take(8)->pluck('houseid');
            $res = House::whereIn('id',$RecommendID)->take(8)->get()->toArray();
            if( count($res) < 8  )
            {
                $num = 8-count($res);
                $defRes = House::orderBy('id','desc')->whereNotIn('id',$RecommendID)->take($num)->get()->toArray();
                return array_collapse($res,$defRes);
            }else
            {
                return $res;
            }
        });
        return $value;
    }
}