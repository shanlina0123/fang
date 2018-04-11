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
    public  function  index($data,$page,$tag="CharList")
    {
        //定义tag的key
        $tagKey = base64_encode(mosaic("",$tag,$page,
            $data["followstatusid"],$data["companyid"],$data["ownadminid"],$data["refereeuserid"],
            $data["makedate"],$data["comedate"],$data["dealdate"]));
        //redis缓存返回
        return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ( $data) {
            //默认条件
            $queryModel=ClientDynamic::with(["dynamicToClient" => function ($query) use($data) {
                    $query->select("id", "name");
                }])
                ->select("clientid","followstatusid","companyid","refereeuserid","ownadminid","housename","commissionid","makedate","comedate","dealdate")
                ->orderBy('created_at','desc');
            //搜索结果
            if(!empty($data["followstatusid"]))$queryModel->where("followstatusid",$data["followstatusid"]);
            if(!empty($data["companyid"]))$queryModel->where("companyid",$data["companyid"]);
            if(!empty($data["ownadminid"]))$queryModel->where("ownadminid",$data["ownadminid"]);
            if(!empty($data["refereeuserid"]))$queryModel->where("refereeuserid",$data["refereeuserid"]);
            if(!empty($data["makedate"]))$queryModel->where("makedate",$data["makedate"]);
            if(!empty($data["comedate"]))$queryModel->where("comedate",$data["comedate"]);
            if(!empty($data["dealdate"]))$queryModel->where("dealdate",$data["dealdate"]);

            //分页
            $list= $queryModel->paginate(config('configure.sPage'));
            //结果检测
            if(empty($list->toArray()))
            {
                responseData(\StatusCode::EMPTY_ERROR,"无结果");
            }
            //返回数据库层查询结果
           return $list;

           });


    }

}