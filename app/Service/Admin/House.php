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
     * @return int
     * 错误信息
     */
    public function errorsMessages()
    {
       $msg = [
           'name.required'=>'用户名不能为空',
           'password.required'=>'密码不能为空'
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

}