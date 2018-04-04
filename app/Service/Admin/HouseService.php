<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;
use App\Model\Data\SelectCateDefault;
use App\Model\House\House;
use App\Service\AdminBase;
use App\Model\Data\SelectCate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HouseService extends AdminBase
{

    /**
     * @return array
     * 验证规则
     */
    public function getRules()
    {
        $rules = [
            'name' => 'required',
            'iscommission' =>'required|numeric',
            'commissionid' =>'required|numeric',
            'ishome' =>'numeric',
            'provinceid' =>'numeric',
            'cityid' =>'numeric',
            'countryid' =>'numeric',
            'streeid' =>'numeric',
            'addr' =>'required|string',
            'fulladdr' =>'required|string',
            'floorpostionid' =>'numeric',
            'floor' =>'required|max',
            'orientationid' =>'numeric',
            'purposeid' =>'numeric',
            'area' =>'required',
            'created_at' =>'date',
            'iselevator' =>'numeric',
            'years' =>'required',
            'decoratestyleid' =>'required|numeric',
            'ownershipid' =>'required|numeric',
            'hasdoublegas' =>'required|numeric',
            'propertyfee' =>'required|string|max:30',
        ];
        return $rules;
    }

    /**
     * @return array
     * 新房规则
     */
    public function getNewRules()
    {
        $rules = [
            'salestatusid' =>'required|numeric',
            'opendate' =>'date',
            'price' =>'required',
            'roomtypeid' =>'required|numeric',
        ];
        return $rules;
    }

    /**
     * @return array
     * 二手房源规则
     */
    public function getSencodRules()
    {
        $rules = [
            'price' =>'required',
            'total' =>'required',
            'roomtypeid' =>'required|numeric',
        ];
        return $rules;
    }

    /**
     * @return array
     * 商铺规则
     */
    public function getShopRules()
    {
        $rules = [
            'total' =>'required',
            'depth' =>'required|max:50',
            'storey' =>'required|max:50',
            'wide' =>'required|max:100',
        ];
        return $rules;
    }
    /**
     * @return int
     * 错误信息
     */
    public function errorsMessages()
    {
       $msg = [
           'name.required'=>'楼盘名称必填',
           'iscommission.required'=>'展示佣金必填',
           'iscommission.numeric'=>'展示佣金为数值',
           'commissionid.numeric'=>'佣金规则必填',
           'ishome.numeric'=>'是否推荐规则数值',
           'provinceid.numeric'=>'省规则数值',
           'cityid.numeric'=>'市规则数值',
           'countryid.numeric'=>'区规则数值',
           'streeid.numeric'=>'街道规则数值',
           'addr.required'=>'请填写地址',
           'fulladdr.required'=>'请填写详细地址',
           'floorpostionid.numeric'=>'楼层位置规则数值',
           'floor.required'=>'楼层必填',
           'floor.max'=>'最大30个字符',
           'orientationid.numeric'=>'朝向规则数值',
           'purposeid.numeric'=>'用途规则数值',
           'created_at.date'=>'发布日期格式有误',
           'iselevator.numeric'=>'电梯规则数值',
           'years.required'=>'年代必填',
           'decoratestyleid.numeric'=>'装修规则数值',
           'ownershipid.numeric'=>'权属规则数值',
           'hasdoublegas.numeric'=>'双气规则数值',
           'propertyfee.numeric'=>'物业费必填',
       ];
       return $msg;
    }

    /**
     * @return array
     * 下拉值
     */
    public function getSelect()
    {
        Cache::forget('getSelect');
        if ( Cache::has('getSelect') )
        {
            $arr = Cache::get('getSelect');
            return $arr;
        }else
        {
            //自定义数据
            $define = array();
            $selectCate = SelectCate::where('status',1)->orderBy('id','asc')->select('id','name')->with('cateToSelect')->get();
            foreach ( $selectCate as $row )
            {
                $defineObject = new \stdClass();
                $defineObject->id = $row->id;
                $defineObject->name = $row->name;
                $defineObject->selectValue = $row->cateToSelect()->where(['cateid'=>$row->id,'status'=>1])->select('id','name','cateid')->get();
                $define[$row->id] = $defineObject;
            }

            //系统数据
            $system = array();
            $selectCateDefault = SelectCateDefault::where('status',1)->orderBy('id','asc')->select('id','name')->with('cateDefaultToSelect')->get();
            foreach ( $selectCateDefault as $default )
            {
                $defaultObject = new \stdClass();
                $defaultObject->id = $default->id;
                $defaultObject->name = $default->name;
                $defaultObject->selectValue = $default->cateDefaultToSelect()->where(['cateid'=>$default->id,'status'=>1])->select('id','name','cateid')->get();
                $system[$default->id] = $defaultObject;
            }
            $arr['define'] = $define;
            $arr['system'] = $system;

            Cache::put('getSelect',$arr,config('configure.sCache'));
            return $arr;
        }
    }

    /**
     * @param $data
     * @return mixed
     * 发布房源
     */
    public function storeHouse( $data )
    {
        try{
            $arr['uuid'] = create_uuid();//楼盘名称
            $arr['name'] = $data['name'];//楼盘名称
            $arr['iscommission'] = $data['iscommission'];//展示拥金
            $arr['commissionid'] = $data['commissionid'];//佣金规则
            $arr['ishome'] = $data['name'];//是否推荐 1推荐 0不推荐
            $arr['provinceid'] = $data['provinceid'];
            $arr['cityid'] = $data['cityid'];
            $arr['countryid'] = $data['countryid'];
            $arr['streeid'] = $data['streeid'];
            $arr['street'] = $data['street'];//街道
            $arr['addr'] = $data['addr'];//地址
            $arr['fulladdr'] = $data['fulladdr'];//地址
            $arr['floorpostionid'] = $data['floorpostionid'];//楼层位置
            $arr['floor'] = $data['floor'];//楼层
            $arr['orientationid'] = $data['orientationid'];//朝向
            $arr['purposeid'] = $data['purposeid'];//用途
            $arr['area'] = $data['area'];//面积
            $arr['created_at'] = $data['created_at'];//发布时间
            $arr['iselevator'] = $data['iselevator'];//电梯
            $arr['years'] = $data['years'];//年代
            $arr['decoratestyleid'] = $data['decoratestyleid'];//装修
            $arr['ownershipid'] = $data['ownershipid'];//权属
            $arr['hasdoublegasid'] = $data['hasdoublegasid'];//双气
            $arr['propertyfee'] = $data['propertyfee'];//物业费
            $arr['typeid'] = (int)$data['typeid'];
            switch ( (int)$data['typeid'] )
            {
                case 1:
                    //新房
                    $arr['salestatusid'] = $data['salestatusid'];//现状
                    $arr['opendate'] = $data['opendate'];//开盘日期
                    $arr['price'] = $data['price'];//单价
                    $arr['roomtypeid'] = $data['roomtypeid'];//房型
                    break;
                case 2:
                    //二手
                    $arr['price'] = $data['price'];//单价
                    $arr['total'] = $data['total'];//总价
                    $arr['roomtypeid'] = $data['roomtypeid'];//房型
                    break;
                case 3:
                    //商铺
                    $arr['total'] = $data['total'];//总价
                    $arr['depth'] = $data['depth'];//进深
                    $arr['storey'] = $data['storey'];//层高
                    $arr['wide'] = $data['wide'];//面宽
                    break;
            }
            $res = House::create( $arr );
            return $res->uuid;
        }catch (Exception $e){
            responseData(\StatusCode::ERROR,'基本信息发布失败',$data);
        }
    }

    /**
     * @param $request
     * @return mixed
     * 房源列表
     */
    public function getList( $request )
    {

        $typeID = $request->input('typeid');
        $name = $request->input('name');
        $isCommission = $request->input('iscommission');
        $cTime = $request->input('created_at');
        if(  $typeID )
        {
            $sWhere['typeid'] = $typeID;
        }
        if(  $isCommission )
        {
            $sWhere['iscommission'] = $isCommission;
        }
        if(  $cTime )
        {
            $sWhere['created_at'] = $cTime;
        }
        $sql = House::where( $sWhere )->orderBy('id','desc');
        if( $name )
        {
            $sql->where('name','%'.$name.'%');
        }
        return $sql->paginate(config('configure.sPage'));
        die();
        $tag = 'houseList';
        $where = $request->input('page').$request->input('typeid').$request->input('name').$request->input('iscommission').$request->input('created_at');
        $where = base64_encode($where);
        $value = Cache::tags($tag)->remember( $tag.$where,config('configure.sCache'), function() use( $request ){
            $typeID = $request->input('typeid');
            $name = $request->input('name');
            $isCommission = $request->input('iscommission');
            $cTime = $request->input('created_at');
            if(  $typeID )
            {
                $sWhere['typeid'] = $typeID;
            }
            if(  $isCommission )
            {
                $sWhere['iscommission'] = $isCommission;
            }
            if(  $cTime )
            {
                $sWhere['created_at'] = $cTime;
            }
            $sql = House::where( $sWhere )->orderBy('id','desc');
            if( $name )
            {
                $sql->where('name','%'.$name.'%');
            }
            return $sql->paginate(config('configure.sPage'));
        });
        return $value;
    }
}