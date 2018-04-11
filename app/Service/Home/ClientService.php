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
use App\Model\House\House;
use App\Model\User\AdminUser;
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
    public function index($userid, $data, $page, $tag = "HomeClientList")
    {
        //定义tag的key
        $tagKey = base64_encode(mosaic("", $tag, $userid, $page, $data["name"], $data["followstatusid"]));
        //redis缓存返回
        return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($userid, $data) {
            //操作数据库
            $sql = DB::table("client_referee")
                ->select("client_referee.userid", "client_referee.clientid", "client_referee.houseid", "client_referee.housename", "client_referee.name", "client_referee.mobile", "client_referee.mobile", "client_referee.created_at",
                    "client_dynamic.levelid", "client_dynamic.followstatusid", "client_dynamic.makedate")
                ->join('client_dynamic', 'client_referee.clientid', '=', 'client_dynamic.clientid')
                ->where("userid", $userid);
            //搜索条件
            if (!empty($data["name"])) {
                $sql->where("name", "like", "%" . $data["name"] . "%");
            }
            //状态搜索
            if (!empty($data["followstatusid"])) {
                $sql->where("followstatusid", $data["followstatusid"]);
            }
            return $sql->paginate(config('configure.sPage'));

        });
    }

    /****
     * 获取房源列表--推荐房源时候模糊搜索的下拉框内容
     */
    public function houseData($data)
    {
        try {
            //获取详情数据
            $row = House::select("id", "name", "addr")->where("name", "like", "%" . $data["name"] . "%")->get();
            if (empty($row)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在");
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
        return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($userid) {
            //推荐量
            $row["refereeCount"] = ClientReferee::where("userid", $userid)->count("id");
            $row = [
                "effectiveCount" => 0,//有效
                "invalidCount" => 0,//无效
                "visitCount" => 0,//已上门
            ];
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

        });
    }

    /***
     * 推荐客户
     */
    public function store($adminid, $userid, $data)
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
            if (empty($houseData->toArray())) {
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
                $adminid=array_random(array_flatten($adminUserList->toArray()));
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
                Cache::tags(["clientList"])->flush();
                Cache::tags(["clientList","HomeClientList","clientRefereeChart"])->flush();

                //TODO:: 发送微信推送消息

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
}