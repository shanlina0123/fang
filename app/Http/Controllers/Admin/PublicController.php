<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Model\Data\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PublicController extends AdminBaseController
{

    /**
     * 上传图片到本地临时目录
     */
    public function uploadImgToTemp(Request $request)
    {
        if( $request->file('file') == false ) return '';
        try {
            $res = $request->file('file')->store('temp', 'temp');
            $name = explode('/',$res)[1];
            $src = new \stdClass();
            $src->src = "http://".$_SERVER['HTTP_HOST'].'/temp/'.$name;
            $src->name = $name;
            responseData(\StatusCode::SUCCESS,'上传成功',$src);
        } catch (Exception $e)
        {
            responseData(\StatusCode::ERROR,'上传失败');
        }
    }

    /**
     *  省市json
     */
    public function getAddress()
    {
        if ( Cache::has('getAddress') )
        {
            $arr = Cache::get('getAddress');
        }else
        {
            $arr = array();
            $res = Province::where('status',1)->with('ProvinceToCity')->get();
            foreach ( $res as $row )
            {
                $defaultObject = new \stdClass();
                $defaultObject->id = $row->id;
                $defaultObject->name = $row->name;
                $defaultObject->city = $row->ProvinceToCity()->where(['provinceid'=>$row->id,'status'=>1])->select('id','name','provinceid')->get();
                $arr[] = $defaultObject;
            }
            Cache::put('getAddress',$arr,config('configure.sCache'));
        }
        responseData(\StatusCode::SUCCESS,'省市信息',$arr);
    }


}
