<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Home;
use App\Model\Conf\WebConf;
use App\Service\HomeBase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConfService extends HomeBase
{


    /***
     * 获取数据源列表 所有
     * @return mixed
     */
    public  function  index()
    {
        //redis缓存数据，无则执行数据库获取业务数据
        // return Cache::get('confList', function() {
        //列表
        $objList=WebConf::where("status",1)->select("id","name","content","pid","created_at")->orderBy('id','asc')->get();
        $list=list_to_tree($objList->toArray());
        //结果检测
        if(empty($list))
        {
            responseData(\StatusCode::EMPTY_ERROR,"无结果");
        }
        //写入redis缓存
        //    Cache::put('confList',$list,config('configure.sCache'));
        //返回数据库层查询结果
        return $list;
        //    });
    }
}