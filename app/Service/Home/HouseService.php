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
        Cache::tags(['HomeHouseList'])->flush();
        $tag = 'HomeHouseList';
        $where = $request->input('page').$request->input('typeid').$request->input('name').$request->input('roomtypeid').$request->input('price');
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
            //价格
            $price = $request->input('price');
            if( $price )
            {
                //判断房源类型
                switch ( (int)$typeID )
                {
                    case 1:
                        //新房
                    case 3:
                        //商铺
                        $priceType = 'total';
                        break;
                    case 2:
                        //二手房
                        $priceType = 'price';
                        break;
                    default:
                        $priceType = 'total';
                        break;
                }
                $arr = explode('-',$price);
                if( count($arr) == 1 )
                {
                    $sql->where( $priceType, '>=', $price );
                }else
                {
                    $arr = array_sort_recursive($arr);
                    $priceWhere = $priceType.' >= '.$arr[0].' AND '.$priceType." <= ".$arr[1];
                    $sql->whereRaw( $priceWhere );
                }
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
        Cache::tags(['HomeRecommend'])->flush();
        $tag = 'HomeRecommend';
        $value = Cache::tags($tag)->remember( $tag,config('configure.sCache'), function(){
            $RecommendID = HouseHome::orderBy('id','desc')->take(8)->pluck('houseid');
            $res = House::whereIn('id',$RecommendID)->take(8)->with(['houseToTag'=>function($query){
                $query->select('tagid','houseid');
            }])->get()->toArray();
            if( count($res) < 8  )
            {
                $num = 8-count($res);
                $defRes = House::orderBy('id','desc')->whereNotIn('id',$RecommendID)->take($num)->with(['houseToTag'=>function($query){
                    $query->select('tagid','houseid');
                }])->get()->toArray();
                return array_merge_recursive($res,$defRes);
            }else
            {
                return $res;
            }
        });
        return $value;
    }

    /**
     * @param $id
     * 房源详情
     */
    public function getInfo( $id )
    {
        $tag = 'HomeInfo';
        $value = Cache::tags($tag)->remember( $tag.$id,config('configure.sCache'), function() use( $id ){
            $res = House::where('id',$id)->first();
            $res->image = $res->houseToImage()->select('url')->get();
            $res->tags = $res->houseToTag()->select('tagid')->get();
            return $res;
        });
        return $value;
    }
}