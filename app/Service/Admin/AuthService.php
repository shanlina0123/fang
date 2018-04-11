<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;

use App\Model\Data\Functions;
use App\Model\Roles\Role;
use App\Model\Roles\RoleFunction;
use App\Service\AdminBase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthService extends AdminBase
{

    /***
     * 获取权限功能列表
     * @return mixed
     */
    public function index()
    {
        //redis缓存数据，无则执行数据库获取业务数据
        return Cache::get('authList', function () {
            //默认条件
            $objList = Functions::select("id", "name", "pid", "level")->orderBy('sort', 'asc')->get();
            //结果检测
            if (empty($objList)) {
                responseData(\StatusCode::EMPTY_ERROR, "无结果");
            }
            //生成tree数组
            $list=list_to_tree($objList->toArray(),"id","pid", '_child',0);
            //写入redis缓存
            Cache::put('authList', $list, config('configure.sCache'));
            //返回数据库层查询结果
            return $list;
        });
    }

    /***
     * 角色详情
     * @param $uuid
     * @return mixed
     */
    public function edit($role_uuid)
    {
        try {

            //获取角色
            $roleData = Role::where("uuid", $role_uuid)->first();
            if (empty($roleData)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "角色不存在");
            }
            //角色id
            $roleid = $roleData->id;
            //获取详情数据
            $objList = RoleFunction::where("roleid", $roleid)->select("functionid")->get();
            if (empty($objList)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "您未设置权限");
            }
            //对象转数组
            $arrList = $objList->toArray();
            //重组为键
            $arrList = i_array_column($arrList, null, "functionid");
            //取键
            $list["functionid"] = array_keys($arrList);
        } catch (\ErrorException $e) {
            //记录日志
            Log::error('======RolesService-edit:======' . $e->getMessage());
            //业务执行失败
            responseData(\StatusCode::CATCH_ERROR, "获取异常");
        } finally {
            //返回处理结果数据
            return $list;
        }
    }


    /***
     * 修改角色 - 执行
     * @param $uuid
     */
    public function update($role_uuid, $data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //检测角色是否存在
            $roleData = Role::where("uuid", $role_uuid)->first();
            if (empty($roleData)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "角色名称不存在");
            }
            //角色id
            $roleid = $roleData->id;

            //检查管理员
            if ($roleid == 1) {
                responseData(\StatusCode::OUT_ERROR, "不能重置管理员权限");
            }
            //检测权限是否存在
            $existCount = Functions::whereIn("id", $data["functionid"])->count("id");
            if ($existCount !== count($data["functionid"])) {
                responseData(\StatusCode::NOT_DEFINED, "存在非定义数值，请移除");
            }

            //业务处理
            foreach ($data["functionid"] as $k => $v) {
                //唯一条件
                $condition["roleid"] = $roleid;
                $condition["functionid"] = $v;
                //判断处理
                $existFR = RoleFunction::where($condition)->exists();
                if (empty($existFR)) {
                    $rolefunc["uuid"] = create_uuid();
                    $rolefunc["roleid"] = $roleid;
                    $rolefunc["functionid"] = $v;
                    $rolefunc["created_at"] = date("Y-m-d H:i:s");
                    $rs[] = RoleFunction::create($rolefunc);
                } else {
                    $rs[] = RoleFunction::where($condition)->delete();
                }
            }

            //结果处理
            if (!in_array(false, $rs, true)) {
                DB::commit();
                //删除缓存
                Cache::forget("authList");
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "勾选失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======RolesService-update:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "勾选异常");
        }
    }


}