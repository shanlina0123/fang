<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Home;

use App\Model\Client\Client;
use App\Model\Client\ClientDispatch;
use App\Model\Client\ClientDynamic;
use App\Model\Client\ClientReferee;
use App\Model\Company\Company;
use App\Model\Data\Select;
use App\Model\Data\SelectDefault;
use App\Model\House\House;
use App\Model\User\AdminUser;
use App\Model\User\Users;
use App\Service\HomeBase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientService extends HomeBase
{
    /***
     * 获取我的客户列表
     * @return mixed
     */
    public function index($userid,$isadminafter, $adminid, $data, $page, $tag = "HomeClientList")
    {
       // Cache::tags($tag)->flush();
        //定义tag的key
        $tagKey = base64_encode(mosaic("", $tag, $userid,$isadminafter,$adminid, $page, $data["name"], $data["followstatusid"]));
        //redis缓存返回
       return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($userid, $isadminafter, $data) {
            //操作数据库
           $pre=getenv("DB_PREFIX")?getenv("DB_PREFIX"):config("configure.DB_PREFIX");
           $aliasA=$pre."a";
           $aliasB=$pre."b";
           $sql = DB::table("client_referee as a");
            //字段 业务员可以--- 产品意思暂时屏蔽
           // if ($isadminafter > 0) {
                $sql->select(DB::raw("$aliasB.uuid,$aliasA.userid,$aliasA.clientid,$aliasA.houseid,$aliasA.housename,$aliasA.name,$aliasA.mobile,$aliasA.created_at,
                    $aliasB.levelid,$aliasB.followstatusid,FROM_UNIXTIME(UNIX_TIMESTAMP($aliasB.makedate),'%m-%d %H:%i') as makedate"));
          //  } else {
                //无客户等级
            //    $sql->select(DB::raw("$aliasB.uuid,$aliasA.userid,$aliasA.clientid,$aliasA.houseid,$aliasA.housename,$aliasA.name,$aliasA.mobile,$aliasA.created_at,
                //    $aliasB.followstatusid,FROM_UNIXTIME(UNIX_TIMESTAMP($aliasB.makedate),'%m-%d %H:%i') as makedate"));
           // }
               //innerjoin
           $sql->join("client_dynamic as b", "a.clientid", '=', "b.clientid")
               ->where("userid", $userid);
            //客户名称 - 搜索条件
            if (!empty($data["name"])) {
                $sql->where("name", "like", "%" . $data["name"] . "%");
            }
           //业务员可以
           // if ($isadminafter > 0) {
           //状态搜索 - 搜索条件
           if (!empty($data["followstatusid"])) {
               $sql->where("followstatusid", $data["followstatusid"]);
           }
           //   }

           return $sql->orderBy("created_at","desc")->paginate(config('configure.sPage'));

      });
    }

    /****
     * 获取房源列表--推荐房源时候模糊搜索的下拉框内容
     */
    public function houseData($data)
    {
        try {
            //获取详情数据
            $queryModel = House::select("id", "name", "addr");
            if($data["name"])
            {
                $queryModel->where("name", "like", "%" . $data["name"] . "%");
            }
            if($data["typeid"])
            {
                $queryModel->where("typeid", $data["typeid"]);
            }
            if($data["uuid"])
            {
                $queryModel->where("uuid", $data["uuid"]);
            }
            $row=$queryModel->get();
            if (empty($row->toArray())) {
                responseData(\StatusCode::EMPTY_ERROR, "无结果");
            }

        } catch (\ErrorException $e) {
            //记录日志
            Log::error('======HouseService-houseData:======' . $e->getMessage());
            //业务执行失败
            responseData(\StatusCode::CATCH_ERROR, "获取异常");
        } finally {
            //返回处理结果数据
            return $row;
        }
    }

    /***
     * 获取我推荐的客户量统计
     */
    public function statistics($userid, $tag = "clientRefereeChart")
    {
        //定义tag的key
        $tagKey = base64_encode(mosaic("", $tag, $userid));
        //redis缓存返回
        Cache::tags($tag)->flush();
       // return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($userid) {
            $row = [
                "refereeCount"=>0,//推荐量
                "effectiveCount" => 0,//有效
                "invalidCount" => 0,//无效
                "visitCount" => 0,//已上门
            ];
            //推荐量
            $row["refereeCount"] = ClientReferee::where("userid", $userid)->count("id");
            //获取数量 ，有效36 无效37  已上门40
            $dynamicCount = ClientDynamic::where("refereeuserid", $userid)->whereIn("followstatusid", [36, 37, 40])->select(DB::raw('count(id) as num, followstatusid'))->groupBy("followstatusid")->get();
            ///设置统计字段
            $dynamicCount = $dynamicCount->toArray();
            if ($dynamicCount) {
                $dynamicCount = array_pluck($dynamicCount, 'num', 'followstatusid');//status作为索引值
                //制作返回值
                foreach ($dynamicCount as $k => $v) {
                    $field = $k == 36 ? "effectiveCount" : ($k == 37 ? "invalidCount" : ($k == 40 ? "visitCount" : ""));
                    array_set($row, $field, $dynamicCount[$k]);//赋值
                }
            }
            //返回数据库层查询结果
            return $row;

       // });
    }

    /***
     * 推荐客户
     */
    public function store($adminid, $userid,$userinfo, $data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //检查companyid是否存在
            $companyExist = Company::where("id", $data["companyid"])->exists();
            if ($companyExist == 0) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "公司不存在");
            }

            //检测房源是否存在
            $houseData = House::where("id", $data["houseid"])->first();
            if (empty($houseData)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "房源不存在");
            }

            //检测手机号是否存在
            $mobileExist = Client::where("mobile", $data["mobile"])->exists();
            if ($mobileExist > 0) {
                responseData(\StatusCode::EXIST_ERROR, "手机号" . $data["mobile"] . "已存在");
            }
            //业务处理

            //获取随机派单后台用户id
            if (empty($adminid)) {
                $adminUserList = AdminUser::select("id")->get();
                $adminid = array_random(array_flatten($adminUserList->toArray()));
            }

            //录入客户信息
            $client["uuid"] = create_uuid();
            $client["name"] = $data["name"];
            $client["mobile"] = $data["mobile"];
            $client["remark"] = $data["remark"];
            $client["created_at"] = date("Y-m-d H:i:s");
            $rsClient = Client::create($client);
            $clientid = $rsClient->id;

            //派单给业务员
            $clientDispatch["uuid"] = create_uuid();
            $clientDispatch["clientid"] = $clientid;
            $clientDispatch["type"] = 1;
            $clientDispatch["remark"] = "推荐客户系统自动派单";
            $clientDispatch["adminid"] = $adminid;
            $clientDispatch["created_at"] = date("Y-m-d H:i:s");
            $rsClientDispatch = ClientDispatch::create($clientDispatch);
            $clientDispatchid = $rsClientDispatch->id;


            //录入客户动态
            $clientDynamic["uuid"] = create_uuid();
            $clientDynamic["clientid"] = $clientid;
            $clientDynamic["companyid"] = $data["companyid"];
            $clientDynamic["houseid"] = $data["houseid"];
            $clientDynamic["housename"] = $houseData["name"];
            $clientDynamic["followstatusid"] = 38;//客户状态
            $clientDynamic["commissionid"] = $houseData["commissionid"];//佣金规则
            $clientDynamic["refereeuserid"] = $userid;// 推荐人id
            $clientDynamic["followadminid"] = $adminid;//后台跟进者id
            $clientDynamic["ownadminid"] = $adminid;//后台客户归属者id
            $clientDynamic["makedate"] = date("Y-m-d H:i:s");//预约时间
            $clientDynamic["created_at"] = date("Y-m-d H:i:s");
            $rsClientDynamic = ClientDynamic::create($clientDynamic);
            $clientDynamicid = $rsClientDynamic->id;

            //录入我的推荐记录
            $clientReferee["uuid"] = create_uuid();
            $clientReferee["clientid"] = $clientid;
            $clientReferee["companyid"] = $data["companyid"];
            $clientReferee["houseid"] = $data["houseid"];
            $clientReferee["housename"] = $houseData["name"];
            $clientReferee["name"] = $data["name"];
            $clientReferee["mobile"] = $data["mobile"];
            $clientReferee["remark"] = $data["remark"];
            $clientReferee["userid"] = $userid;
            $clientReferee["created_at"] = date("Y-m-d H:i:s");
            $rsClientReferee = ClientReferee::create($clientReferee);
            $clientRefereeid = $rsClientReferee->id;
            //结果处理
            if ($clientid !== false && $clientDispatchid !== false && $clientDynamicid !== false && $clientRefereeid !== false) {
                DB::commit();
                //TODO::删除后端客户列表缓存、前端客户列表缓存、客户推荐统计缓存
                Cache::tags(["clientList", "HomeClientList", "clientRefereeChart"])->flush();

                //TODO:: 发送微信推送消息：登录openid 客户名称, 客户电话$phone, 楼盘 名称$name
                if($userinfo["openid"])
                {
                    $wx= new \WeChat();
                    $wx->sendNotice($userinfo["openid"], $data["name"],$data["mobile"],$houseData["name"]);
                }

            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "推荐失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======ClientService-store:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "推荐异常");
        }
    }

    /***
     * 修改级别和客户状态
     */
    public  function  update($uuid,$userid,$data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //业务处理
            //检查为空
            $row = ClientDynamic::where("uuid", $uuid)->first();
            if (empty($row)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在");
            }else{
                //检查客户是否是自己的
                if($userid!==$row["refereeuserid"])
                {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "该客户不是您的客户，不能进行操作");
                }
            }

            //检查levelid是否存在
            if($data["levelid"])
            {
                $levelExist=Select::where(["cateid"=>4,"id"=>$data["levelid"]])->exists();
                if($levelExist==0)
                {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "请求的客户等级数据不存在");
                }
            }
            //检查客户状态是否存在
            if($data["followstatusid"])
            {
                $statusExist=SelectDefault::where(["cateid"=>8,"id"=>$data["followstatusid"]])->exists();
                if($statusExist==0)
                {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "请求的客户状态数据不存在");
                }
            }
            //整理修改数据
            $data["levelid"]?$client["levelid"] = $data["levelid"]:"";
            $data["followstatusid"]?$client["followstatusid"] = $data["followstatusid"]:"";
            $client["updated_at"] = date("Y-m-d H:i:s");
            //修改数据
            $rs = ClientDynamic::where("uuid", $uuid)->update($client);
            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::tags(["clientList", "HomeClientList", "clientRefereeChart"])->flush();
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "修改失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======ClientService-update:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "修改异常");
        }
    }


}