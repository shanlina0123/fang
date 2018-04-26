<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;
use App\Model\Data\Select;
use App\Model\Data\SelectCateDefault;
use App\Model\House\House;
use App\Model\House\HouseHome;
use App\Model\House\HouseImage;
use App\Model\House\HouseTag;
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
            'commissionid' =>'sometimes|required|numeric',
            'ishome' =>'numeric',
            'provinceid' =>'numeric',
            'cityid' =>'numeric',
            'stree' =>'present',
            'addr' =>'required|string',
            'fulladdr' =>'required|string',
            'floorpostionid' =>'sometimes|numeric',
            'floor' =>'sometimes|required|max',
            'orientationid' =>'numeric',
            'purposeid' =>'numeric',
            'area' =>'required',
            'created_at' =>'sometimes|date',
            'iselevator' =>'sometimes|numeric',
            'years' =>'sometimes|required',
            'decoratestyleid' =>'sometimes|required|numeric',
            'ownershipid' =>'required|numeric',
            'hasdoublegas' =>'sometimes|required|numeric',
            'propertyfee' =>'sometimes|required|string|max:30',
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
            'salestatusid' =>'sometimes|required|numeric',
            'opendate' =>'sometimes|date',
            'price' =>'sometimes|required',
            'roomtypeid' =>'sometimes|required|numeric',
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
            'depth' =>'sometimes|required|max:50',
            'storey' =>'sometimes|required|max:50',
            'wide' =>'sometimes|required|max:100',
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
        //Cache::forget('getSelect');
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
    public function storeHouse( $data, $adminid )
    {

        try{
            $arr['uuid'] = create_uuid();//楼盘名称
            $arr['name'] = $data['name'];//楼盘名称
            $arr['iscommission'] = array_has($data,'iscommission')?$data['iscommission']:0;//展示拥金
            $arr['commissionid'] =  array_has($data,'commissionid')?$data['commissionid']:0;//佣金规则
            $arr['ishome'] = $data['ishome'];//是否推荐 1推荐 0不推荐
            $arr['provinceid'] = $data['provinceid'];
            $arr['cityid'] = $data['cityid'];
            $arr['street'] = $data['street'];//街道
            $arr['addr'] = $data['addr'];//地址
            $arr['fulladdr'] = $data['fulladdr'];//地址
            $arr['floorpostionid'] = $data['floorpostionid'];//楼层位置
            $arr['floor'] = $data['floor'];//楼层
            $arr['orientationid'] = $data['orientationid'];//朝向
            $arr['purposeid'] = $data['purposeid'];//用途
            $arr['area'] = $data['area'];//面积
            $arr['created_at'] = $data['created_at']?$data['created_at']:date('Y-m-d H:i:s');//发布时间

            $arr['iselevator'] = $data['iselevator'];//电梯
            $arr['years'] = $data['years'];//年代

            $arr['decoratestyleid'] = $data['decoratestyleid'];//装修
            $arr['ownershipid'] = $data['ownershipid'];//权属
            $arr['hasdoublegasid'] = $data['hasdoublegasid'];//双气
            $arr['propertyfee'] = $data['propertyfee'];//物业费

            $arr['typeid'] = (int)$data['typeid'];
            $arr['status'] = 0;
            $arr['lng'] = $data['lng'];
            $arr['lat'] = $data['lat'];
            $arr['adminid'] = $adminid;

            switch ( (int)$data['typeid'] )
            {
                case 1:
                    //新房
                    $arr['salestatusid'] = $data['salestatusid'];//现状
                    $arr['opendate'] = $data['opendate']?$data['opendate']:"(NULL)";//开盘日期
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

            $res = House::insertGetId( $arr );
            //首页推荐
            if(  $data['ishome'] == 1 )
            {
                $home = new HouseHome();
                $home->cityid = $data['cityid'];
                $home->houseid = $res;
                $home->save();
            }
            Cache::tags(['houseList','HomeHouseList'])->flush();
            return base64_encode($res);
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
        $tag = 'houseList';
        $where = $request->input('page').$request->input('typeid').$request->input('name').$request->input('iscommission').$request->input('created_at');
        $where = base64_encode($where);
        $value = Cache::tags($tag)->remember( $tag.$where,config('configure.sCache'), function() use( $request ){
            $typeID = $request->input('typeid');
            $name = $request->input('name');
            $isCommission = $request->input('iscommission');
            $cTime = $request->input('created_at');
            $sql = House::orderBy('id','desc');
            if(  $typeID )
            {
                $sql->where('typeid',$typeID);
            }
            if(  $isCommission != '' )
            {
                $sql->where('iscommission',$isCommission);
            }
            if(  $cTime )
            {
                $sql->whereDate('created_at','>=',trim(explode('|',$cTime)[0]))->whereDate('created_at','<=',trim(explode('|',$cTime)[1]));
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
     * @param $request
     * @return mixed
     * 发布标签
     */
    public function saveTag( $request )
    {
        try{
            $arr = array();
            foreach ( $request['tagid'] as $key=>$row )
            {
                $arr[$key]['uuid'] = create_uuid();
                $arr[$key]['tagid'] = $row;
                $arr[$key]['houseid'] = $request['houseid'];
            }
            $obj = HouseTag::insert( $arr );
            if( $obj )
            {
                Cache::tags(['houseList','HomeHouseList','HomeRecommend','HomeInfo'])->flush();
                return base64_encode($request['houseid']);
            }else
            {
                responseData(\StatusCode::ERROR,'写入失败');
            }
        }catch (Exception $e){
            responseData(\StatusCode::ERROR,'写入失败');
        }
    }


    /**
     * @param $request
     * @return bool
     * 图片上传
     */
    public function saveImg( $request )
    {
        try{
            DB::beginTransaction();
            $upload = new \Upload();
            foreach ( $request['images'] as $row )
            {
                $res = $upload->uploadProductImage( $request['houseid'], $row, 'house' );
                if( $res )
                {
                    $arr['uuid'] = create_uuid();
                    $arr['url'] = '/house/'.$request['houseid'].'/'.$row;
                    $arr['houseid'] = $request['houseid'];
                    $arr['created_at'] = date("Y-m-d H:i:s");
                    HouseImage::insert($arr);
                }
            }
            //上传封面
            $covermap = $upload->uploadProductImage( $request['houseid'], $request['covermap'], 'house' );
            if( $covermap )
            {
                $obj = House::find($request['houseid']);
                $obj->covermap = '/house/'.$request['houseid'].'/'.$request['covermap'];
                $obj->status = $request['status'];
                $obj->save();
            }
            DB::commit();
            Cache::tags(['houseList','HomeHouseList','HomeRecommend','HomeInfo'])->flush();
            return 'success';
        }catch (Exception $e){
            DB::rollBack();
            responseData(\StatusCode::ERROR,'写入失败');
        }
    }

    /**
     * @param $uuid
     * 房源信息
     */
    public function editHouse( $uuid )
    {
        $res = House::where('uuid',$uuid)->first();
        if( $res )
        {
            return $res;
        }else
        {
            responseData(\StatusCode::ERROR,'未查询到数据');
        }
    }

    /**
     * @param $uuid
     * 删除房源
     */
    public function destroyHouse( $uuid )
    {
        try{
            DB::beginTransaction();
            $res = House::where('uuid',$uuid)->first();
            $houseID = $res->id;
            if( $res )
            {
                 HouseTag::where('houseid',$houseID)->delete();
                 HouseImage::where('houseid',$houseID)->delete();
                 HouseHome::where('houseid',$houseID)->delete();
                 $res->delete();

            }else
            {
                responseData(\StatusCode::ERROR,'未查询到数据');
            }
            Cache::tags(['houseList','HomeHouseList','HomeRecommend'])->flush();
            //删除图片
            (new \Upload())->delDir('house',$houseID);
            DB::commit();
            return 'success';
        }catch (Exception $e){
            DB::rollBack();
            responseData(\StatusCode::ERROR,'删除失败');
        }
    }

    /**
     * @param $data
     * 修改房源
     */
    public function updateHouse( $data )
    {
        try{
            DB::beginTransaction();
            $obj = House::where('uuid',$data['uuid'])->first();
            if( $obj == false )
            {
                responseData(\StatusCode::ERROR,'未查询到数据');
            }
            $obj->name = $data['name'];//楼盘名称
            $obj->iscommission = $data['iscommission'];//展示拥金
            $obj->commissionid = $data['commissionid'];//佣金规则
            $obj->ishome = $data['ishome'];//是否推荐 1推荐 0不推荐
            $obj->provinceid = $data['provinceid'];
            $obj->cityid = $data['cityid'];
            $obj->street = $data['street'];//街道
            $obj->addr = $data['addr'];//地址
            $obj->fulladdr = $data['fulladdr'];//地址
            $obj->floorpostionid = $data['floorpostionid'];//楼层位置
            $obj->floor = $data['floor'];//楼层
            $obj->orientationid = $data['orientationid'];//朝向
            $obj->purposeid = $data['purposeid'];//用途
            $obj->area = $data['area'];//面积
            $obj->created_at = $data['created_at'];//发布时间
            $obj->iselevator = $data['iselevator'];//电梯
            $obj->years = $data['years'];//年代
            $obj->decoratestyleid = $data['decoratestyleid'];//装修
            $obj->ownershipid = $data['ownershipid'];//权属
            $obj->hasdoublegasid = $data['hasdoublegasid'];//双气
            $obj->propertyfee = $data['propertyfee'];//物业费
            $obj->status = $data['status'];
            $obj->lng = $data['lng'];
            $obj->lat = $data['lat'];
            switch ( (int)$data['typeid'] )
            {
                case 1:
                    //新房
                    $obj->salestatusid = $data['salestatusid'];//现状
                    $obj->opendate = $data['opendate']?$data['opendate']:"(NULL)";//开盘日期
                    $obj->price = $data['price'];//单价
                    $obj->roomtypeid = $data['roomtypeid'];//房型
                    break;
                case 2:
                    //二手
                    $obj->price = $data['price'];//单价
                    $obj->total = $data['total'];//总价
                    $obj->roomtypeid = $data['roomtypeid'];//房型
                    break;
                case 3:
                    //商铺
                    $obj->total = $data['total'];//总价
                    $obj->depth = $data['depth'];//进深
                    $obj->storey = $data['storey'];//层高
                    $obj->wide = $data['wide'];//面宽
                    break;
            }
            //修改房源信息
            $obj->save();

            //首页推荐
            if(  $data['ishome'] == 1 )
            {
                HouseHome::where('houseid',$obj->id)->delete();
            }

            DB::commit();
            Cache::tags(['houseList','HomeHouseList','HomeRecommend','HomeInfo'])->flush();
            return base64_encode($obj->id);
        }catch (Exception $e)
        {
            DB::rollBack();
            responseData(\StatusCode::ERROR,'编辑失败',$data);
        }
    }

    /**
     * @param $data
     * 房源推荐
     */
    public function recommendHouse( $data )
    {
        $res =  House::where(['uuid'=>$data['uuid']])->first();
        if( $res == false )
        {
            responseData(\StatusCode::ERROR,'未查询到数据');
        }
        $obj = new HouseHome();
        $obj->cityid = $res->cityid;
        $obj->houseid = $res->id;
        if( $obj->save() )
        {
            Cache::tags(['houseList','HomeHouseList','HomeRecommend'])->flush();
            return 'success';
        }
        responseData(\StatusCode::ERROR,'推荐失败');
    }


    /**
     * 修改房签
     */
    public function editTag( $id )
    {
        $id = base64_decode($id);
        $tag = HouseTag::where('houseid',$id)->pluck('tagid')->toArray();
        if( count($tag) )
        {
            $res = new \stdClass();
            $res->tag = $tag;
            $arr = array();
            $tages = Select::where(['cateid'=>5,'status'=>1])->get();
            foreach ( $tages as $row )
            {
                $obj = new \stdClass();
                $obj->name = $row->name;
                $obj->id = $row->id;
                if( in_array( $obj->id, $tag) )
                {
                    $chencked = true;
                    $obj->istag = 1;
                }else
                {
                    $chencked = false;
                    $obj->istag = 0;
                }
                $obj->chencked = $chencked;
                $arr[] = $obj;
            }
            $res->data = $arr;
            return $res;
        }else
        {
            responseData(\StatusCode::ERROR,'未查到信息');
        }
    }


    /**
     * @param $data
     * @return string
     * 修改保存标签
     */
    public function saveEditTag( $data )
    {
        //修改标签
        if( array_has($data,'tagid') &&  $data['tagid'] )
        {
            $k = 0;
            $arr = array();
            foreach ( $data['tagid'] as $row )
            {
                $res = HouseTag::where(['houseid'=> $data['houseid'],'tagid'=>(int)$row])->first();
                if( !$res )
                {
                    $arr[$k]['uuid'] = create_uuid();
                    $arr[$k]['tagid'] = $row;
                    $arr[$k]['houseid'] = $data['houseid'];
                    $arr[$k]['created_at'] = date('Y-m-d H:i:s');
                    $arr[$k]['updated_at'] = date('Y-m-d H:i:s');
                    $k++;
                }
            }
            if( count($arr) )
            {
                HouseTag::insert( $arr );
            }
        }

        //删除标签
        if(  array_has($data,'del_tagid') &&  $data['del_tagid'] )
        {
            if( is_array($data['del_tagid']) )
            {
                HouseTag::where('houseid',$data['houseid'])->whereIn('tagid',$data['del_tagid'])->delete();
            }
        }

        return base64_encode($data['houseid']);
    }


    /**
     * @param $id
     * @return \stdClass
     * 图片信息
     */
    public function editImage( $id )
    {
        $id = base64_decode($id);
        $img = HouseImage::where('houseid',$id)->get();
        $covermap = House::where('id',$id)->value('covermap');
        if( count( $img ) )
        {
            $obj = new \stdClass();
            $arr = array();
            foreach ( $img as $row )
            {
                $arr[] = $row->url;
            }
            $obj->img = $arr;
            $obj->res = $img;
            $obj->covermap = $covermap;
            return $obj;
        }else
        {
            responseData(\StatusCode::ERROR,'未查到信息');
        }
    }


    /**
     * @param $data
     * 保存图片
     */
    public function editImageSave( $data )
    {
        try{
            DB::beginTransaction();
            $upload = new \Upload();
            if( array_has($data,'addImg') && $data['addImg'])
            {
                //上传
                foreach ( $data['addImg'] as $row )
                {

                    $res = $upload->uploadProductImage( $data['houseid'], $row, 'house' );
                    if( $res )
                    {
                        $arr['uuid'] = create_uuid();
                        $arr['url'] = '/house/'.$data['houseid'].'/'.$row;
                        $arr['houseid'] = $data['houseid'];
                        $arr['created_at'] = date("Y-m-d H:i:s");
                        HouseImage::insert($arr);
                    }
                }
            }
            if( array_has($data,'delImg') && $data['delImg'] )
            {
                //删除
                foreach ( $data['delImg'] as $row )
                {

                    $res = $upload->delImg(  $row );
                    if( $res )
                    {
                        HouseImage::where(['url'=>$row,'houseid'=>$data['houseid']])->delete();
                    }
                }
            }
            //上传封面
            if(  array_has($data,'addcovermap') && $data['addcovermap'] )
            {
                $covermap = $upload->uploadProductImage( $data['houseid'], $data['addcovermap'], 'house' );
                if( $covermap )
                {
                    $obj = House::where('id', $data['houseid'])->first();
                    $obj->covermap = '/house/'.$data['houseid'].'/'.$data['addcovermap'];
                    $obj->save();
                }
            }
            Cache::tags(['houseList','HomeHouseList','HomeRecommend','HomeInfo'])->flush();
            DB::commit();
            return 'success';
        }catch (Exception $e)
        {
            DB::rollBack();
            responseData(\StatusCode::ERROR,'编辑失败');
        }
    }

}