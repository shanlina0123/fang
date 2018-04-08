<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;
use App\Model\Client\ClientDynamic;
use App\Service\AdminBase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChartService extends AdminBase
{

    /***
     * 获取角色列表
     * @return mixed
     */
    public  function  index()
    {
        //redis缓存数据，无则执行数据库获取业务数据
       // return Cache::get('chartList', function() {
            //默认条件
            $list=ClientDynamic::with("dynamicToClient")->orderBy('id','asc')->paginate(config('configure.sPage'));
            //结果检测
            if(empty($list))
            {
                responseData(\StatusCode::EMPTY_ERROR,"无结果");
            }
            //写入redis缓存
        //    Cache::put('chartList',$list,config('configure.sCache'));
            //返回数据库层查询结果
            return $list;
    //    });
    }



}