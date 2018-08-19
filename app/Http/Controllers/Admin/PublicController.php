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
//    public function uploadImgToTemp(Request $request)
//    {
//
//        if ($request->hasFile('file'))
//        {
//            $file = $request->file('file');
//            $name = md5(uniqid()).'.'.$file->getClientOriginalExtension();
//            $request->file('file')->move('temp/',$name);
//            $src = new \stdClass();
//            $src->src = "http://".$_SERVER['HTTP_HOST'].'/temp/'.$name;
//            $src->name = $name;
//            responseData(\StatusCode::SUCCESS,'上传成功',$src);
//        }else
//        {
//            responseData(\StatusCode::ERROR,'上传失败');
//        }
//    }
    /**
     * 上传图片到本地临时目录
     */
    public function uploadImgToTemp(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                //检验大小
                $filesize=$file->getSize();
                if(!$filesize || $filesize>config("configure.maxImgSizeByte"))
                {
                    responseData(\StatusCode::ERROR, $filesize."图片大小不能低于0或超过".config("configure.maxImgSize"));
                }

                //检验文件类型
                $fileTypes = array('image/jpeg','image/png');
                $filetype=$file->getMimeType();
                if(!in_array($filetype,$fileTypes)) {
                    responseData(\StatusCode::ERROR, '文件格式不合法'.$filetype);
                }

                $name = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
                $request->file('file')->move('temp/', $name);
                $src = new \stdClass();
                $src->src = "http://" . $_SERVER['HTTP_HOST'] . '/temp/' . $name;
                $src->name = $name;
                responseData(\StatusCode::SUCCESS, '上传成功', $src);
            } else {
                responseData(\StatusCode::ERROR, '上传失败');
            }
        } catch (Exception $e)
        {
            responseData(\StatusCode::ERROR, '上传失败');
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

    /**
     *  获取腾讯地图搜索的地址
     */
    public function getMapAddress( Request $request )
    {
        $keyword = $request->input('keyword');
        if( $keyword )
        {
            $url = 'https://apis.map.qq.com/ws/place/v1/suggestion/?region=西安&filter%3Dcategory%3D%E5%B0%8F%E5%8C%BA&keyword='.$keyword.'&key=N6LBZ-XRSWP-NM5DY-LW7S6-GCKO7-WBFF7';
            $data = $this->curlGetDate($url);
            responseData(\StatusCode::SUCCESS,'地址',$data);

        }else
        {
            responseData(\StatusCode::ERROR,'查询失败');
        }
    }

    /**
     * @param $url
     * @return mixed
     * curl get请求
     */
    public function curlGetDate( $url )
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output);
    }

}
