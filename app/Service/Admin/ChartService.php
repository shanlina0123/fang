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
     * 获取客户数据分析列表
     * @return mixed
     */
    public  function  index()
    {
            //默认条件
            $list=ClientDynamic::with("dynamicToClient")->select("clientid","followstatusid","companyid","refereeuserid","ownuserid","housename","commissionid","makedate","comedate","dealdate")->orderBy('created_at','desc')->paginate(config('configure.sPage'));
            //结果检测
            if(empty($list))
            {
                responseData(\StatusCode::EMPTY_ERROR,"无结果");
            }
            //返回数据库层查询结果
            return $list;

    }

}