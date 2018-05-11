<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Home;
use App\Model\User\AdminUser;
use App\Service\HomeBase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChartService extends HomeBase
{

    /***
     * 获取业务员列表
     * @return mixed
     */
    public  function  getAdmins()
    {
        //默认条件
        $list=AdminUser::where("status",1)->select("id","uuid","nickname")->orderBy('id','asc')->get();
        //结果检测
        if(empty($list))
        {
            responseData(\StatusCode::EMPTY_ERROR,"无结果");
        }
        //返回数据库层查询结果
        return $list;
    }

}