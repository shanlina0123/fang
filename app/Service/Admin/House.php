<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;
use App\Model\Data\SelectCateDefault;
use App\Service\AdminBase;
use App\Model\Data\SelectCate;
use Illuminate\Support\Facades\Cache;

class House extends AdminBase
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
        //Cache::forget('getSelect');
        if ( Cache::has('getSelect') )
        {
            $arr = Cache::get('getSelect');
            return ['status'=>\StatusCode::PUBLIC_STATUS,'messages'=>'发布房源下拉列表数据','data'=>$arr];
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
            return ['status'=>\StatusCode::PUBLIC_STATUS,'messages'=>'发布房源下拉列表数据','data'=>$arr];
        }
    }

    public function storeHouse()
    {

    }

}