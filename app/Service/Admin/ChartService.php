<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;
use App\Model\Client\ClientDynamic;
use App\Model\User\AdminUser;
use App\Model\User\Users;
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
            if(!empty($data["makedate"]))
            {
                $queryModel->whereDate('makedate','>=',trim(explode('|',$data["makedate"])[0]))->whereDate('makedate','<=',trim(explode('|',$data["makedate"])[1]));
            }
            if(!empty($data["comedate"]))
            {
                $queryModel->whereDate('comedate','>=',trim(explode('|',$data["comedate"])[0]))->whereDate('comedate','<=',trim(explode('|',$data["comedate"])[1]));
            }
            if(!empty($data["dealdate"]))
            {
                $queryModel->whereDate('dealdate','>=',trim(explode('|',$data["dealdate"])[0]))->whereDate('dealdate','<=',trim(explode('|',$data["dealdate"])[1]));
            }
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

    /***
     * excel数据
     * @param $data
     * @param string $tag
     * @return mixed
     */
    public  function  excellist($data,$tag="CharList")
    {
        set_time_limit(0);
       $tagKey = base64_encode(mosaic("",$tag,"excel",
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
            if(!empty($data["makedate"]))
            {
                $queryModel->whereDate('makedate','>=',trim(explode('|',$data["makedate"])[0]))->whereDate('makedate','<=',trim(explode('|',$data["makedate"])[1]));
            }
            if(!empty($data["comedate"]))
            {
                $queryModel->whereDate('comedate','>=',trim(explode('|',$data["comedate"])[0]))->whereDate('comedate','<=',trim(explode('|',$data["comedate"])[1]));
            }
            if(!empty($data["dealdate"]))
            {
                $queryModel->whereDate('dealdate','>=',trim(explode('|',$data["dealdate"])[0]))->whereDate('dealdate','<=',trim(explode('|',$data["dealdate"])[1]));
            }

            $queryModel->with(["dynamicToCompany" => function ($query) use($data) {
                $query->select("id", "name");
            }]);
            $queryModel->with(["dynamicToUser" => function ($query) use($data) {
                $query->select("id", "nickname");
            }]);
            $queryModel->with(["dynamicToAdminOwn" => function ($query) use($data) {
                $query->select("id", "nickname");
            }]);
            $queryModel->with(["dynamicToSelectComm" => function ($query) use($data) {
                $query->select("id", "name");
            }]);
            $queryModel->with(["dynamicToSelectStatus" => function ($query) use($data) {
                $query->select("id", "name");
            }]);
            $list= $queryModel->get();
            //'客户姓名','客户状态',"合作公司","业务员","经纪人","楼盘","佣金规则","预约时间","上门时间","成交时间";
            foreach($list as $k=>$v)
            {
                $excelList[$k+1]=[
                    ($k+1),
                    ($v["dynamicToClient"]["name"]?$v["dynamicToClient"]["name"]:""),
                    ($v["dynamicToSelectComm"]["name"]?$v["dynamicToSelectComm"]["name"]:""),
                    ($v["dynamicToCompany"]["name"]?$v["dynamicToCompany"]["name"]:""),
                    ($v["dynamicToAdminOwn"]["nickname"]?$v["dynamicToAdminOwn"]["nickname"]:""),
                    ($v["dynamicToUser"]["nickname"]?$v["dynamicToUser"]["nickname"]:""),
                    ($v["housename"]?$v["housename"]:""),
                    ($v["dynamicToSelectComm"]["name"]?$v["dynamicToSelectComm"]["name"]:""),
                    (($v["makedate"]&&$v["makedate"]!="0000-00-00 00:00:00"&&$v["makedate"]!="1970-01-01 00:00:00")?$v["makedate"]:""),
                    (($v["comedate"]&&$v["comedate"]!="0000-00-00 00:00:00"&&$v["comedate"]!="1970-01-01 00:00:00")?$v["comedate"]:""),
                    (($v["dealdate"]&&$v["dealdate"]!="0000-00-00 00:00:00"&&$v["dealdate"]!="1970-01-01 00:00:00")?$v["dealdate"]:""),
                ];
            }
            return $excelList;

        });


    }


    /***
     * 获取经纪人列表
     * @return mixed
     */
    public  function  getUsers()
    {
        //默认条件
        $list=Users::select("id","nickname","isadminafter")->orderBy('id','asc')->get();
        //结果检测
        if(empty($list))
        {
            responseData(\StatusCode::EMPTY_ERROR,"无结果");
        }
        //返回数据库层查询结果
        return $list;
    }



    /***
     * 获取业务员列表
     * @return mixed
     */
    public  function  getAdmins()
    {
        //默认条件
        $list=AdminUser::select("id","uuid","nickname")->orderBy('id','asc')->get();
        //结果检测
        if(empty($list))
        {
            responseData(\StatusCode::EMPTY_ERROR,"无结果");
        }
        //返回数据库层查询结果
        return $list;
    }

    /***
     * 导出excel
     * @param $tag
     * @param $tagKey
     */
    public function export($search,$tag="CharList")
    {
        //业务数据
        $search= base64_decode($search);
        $tagKey=base64_encode($tag.$search);
        $cellData= Cache::tags($tag)->get($tagKey);
        $cellData[0]=['ID','客户姓名','客户状态',"合作公司","业务员","经纪人","楼盘","佣金规则","预约时间","上门时间","成交时间"];
        sort($cellData);
        $this->exportExcel("数据分析","客户数据",$cellData);
    }
}