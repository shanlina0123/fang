<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;

use App\Model\Roles\Role;
use App\Model\User\AdminUser;
use App\Model\User\Users;
use App\Service\AdminBase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminService extends AdminBase
{

    /***
     * 获取角色列表
     * @return mixed
     */
    public function index()
    {
        //redis缓存数据，无则执行数据库获取业务数据
        return Cache::get('adminList', function () {
            //默认条件
            $list = AdminUser::select("uuid", "nickname", "name", "roleid", "mobile", "isadmin", "status")->orderBy('id', 'asc')->get();
            //结果检测
            if (empty($list)) {
                responseData(\StatusCode::EMPTY_ERROR, "无结果");
            }
            //写入redis缓存
            Cache::put('adminList', $list, config('configure.sCache'));
            //返回数据库层查询结果
            return $list;
        });
    }

    /***
     * 用户详情
     * @param $uuid
     * @return mixed
     */
    public function edit($uuid)
    {
        try {
            //获取详情数据
            $row = AdminUser::select("uuid", "nickname", "name", "roleid", "mobile", "isadmin", "status", "created_at")->where("uuid", $uuid)->first();
            if (empty($row)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在");
            }

            //检查管理员信息
            if ($row["isadmin"] == 1) {
                responseData(\StatusCode::OUT_ERROR, "不能查看管理员信息");
            }
        } catch (\ErrorException $e) {
            //记录日志
            Log::error('======AdminService-edit:======' . $e->getMessage());
            //业务执行失败
            responseData(\StatusCode::CATCH_ERROR, "获取异常");
        } finally {
            //返回处理结果数据
            return $row;
        }
    }

    /***
     * 新增用户 - 执行
     * @param $data
     */
    public function store($data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //检查管理员
            if ($data["roleid"] == 1) {
                responseData(\StatusCode::OUT_ERROR, "不能选择管理员角色");
            }

            //检查roleid是否存在
            $roleExist = Role::where("id", $data["roleid"])->exists();
            if ($roleExist == 0) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "角色值不存在");
            }

            //检测是否存在
            $existName = AdminUser::where("name", $data["name"])->exists();
            if ($existName > 0) {
                responseData(\StatusCode::EXIST_ERROR, "账号" . $data["name"] . "已存在");
            }

            //检测是否存在
            $existNickName = AdminUser::where("nickname", $data["nickname"])->exists();
            if ($existNickName > 0) {
                responseData(\StatusCode::EXIST_ERROR, "姓名" . $data["nickname"] . "已存在");
            }

            //检测是否存在
            $existMobile = AdminUser::where("mobile", $data["mobile"])->exists();
            if ($existMobile > 0) {
                responseData(\StatusCode::EXIST_ERROR, "手机号" . $data["mobile"] . "已存在");
            }

            //业务处理
            //整理新增数据
            $admin["uuid"] = create_uuid();
            $admin["name"] = $data["name"];
            $admin["nickname"] = $data["nickname"];
            $admin["roleid"] = $data["roleid"];
            $admin["mobile"] = $data["mobile"];
            $admin["password"] = optimizedSaltPwd($data['password']);
            $admin["created_at"] = date("Y-m-d H:i:s");
            //录入数据
            $rsAdmin = AdminUser::create($admin);
            $adminid = $rsAdmin->id;

            //检测房产经纪人是否存在
            $UserData = Users::where("mobile", $data["mobile"])->first();
            if (empty($UserData)) {
                $user["uuid"] = create_uuid();
                $user["companyid"] = 1;
                $user["name"] = $data["name"];
                $user["nickname"] = $data["nickname"];
                $user["mobile"] = $data["mobile"];
                $user["password"] = $data["password"];
                $user["economictid"] = 42;//房产经纪人
                $user["isadminafter"] = 1;//是后端用户
                $user["adminid"] = $adminid;//后端用户id
                $user["created_at"] = date("Y-m-d H:i:s");
                $rsUser = Users::create($user);
                $userid = $rsUser->id;
            }else{
                $userid=1;
            }

            //结果处理
            if ($adminid !== false && $userid !== false) {
                DB::commit();
                //删除缓存
                Cache::forget("adminList");
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "新增失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AdminService-store:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "新增异常");
        }
    }


    /***
     * 修改用户 - 执行
     * @param $uuid
     */
    public function update($uuid, $data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //业务处理
            //检查管理员信息
            $row = AdminUser::where("uuid", $uuid)->first();
            if ($row["isadmin"] == 1) {
                responseData(\StatusCode::OUT_ERROR, "不能查看管理员信息");
            }

            //检查roleid是否存在
            $roleExist = Role::where("id", $data["roleid"])->exists();
            if ($roleExist == 0) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "角色值不存在");
            }

            //检测是否存在
            $existName = AdminUser::where("name", $data["name"])->exists();
            if ($existName > 0) {
                responseData(\StatusCode::EXIST_ERROR, "账号" . $data["name"] . "已存在");
            }


            //检测手机号是否被占用
            if ($row["mobile"] !== $data["mobile"]) {
                $existMobile = AdminUser::where("mobile", $data["mobile"])->exists();
                if ($existMobile > 0) {
                    responseData(\StatusCode::EXIST_ERROR, "手机号" . $data["mobile"] . "已存在");
                }
            }


            //整理修改数据
            $admin["name"] = $data["name"];
            $admin["roleid"] = $data["roleid"];
            $admin["mobile"] = $data["mobile"];
            $admin["password"] = optimizedSaltPwd($data['password']);
            $admin["updated_at"] = date("Y-m-d H:i:s");
            //修改Admin数据
            $rs = AdminUser::where("uuid", $uuid)->update($admin);
            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::forget("adminList");
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "修改失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AdminService-update:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "修改异常");
        }
    }

    /***
     * 启动禁用用户 - 执行
     * @param $uuid
     */
    public function setting($uuid)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //业务处理
            //检测存在
            $adminData = AdminUser::where("uuid", $uuid)->first();
            if (empty($adminData)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在");
            }
            //管理员不能被修改
            if ($adminData["isadmin"] == 1) {
                responseData(\StatusCode::OUT_ERROR, "不能设置管理员信息");
            }

            //整理修改数据
            $admin["status"] = abs($adminData["status"] - 1);
            $admin["updated_at"] = date("Y-m-d H:i:s");
            //修改数据
            $rs = AdminUser::where("uuid", $uuid)->update($admin);

            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::forget("adminList");
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "设置失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AdminService-update:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "设置异常");
        }
    }

}