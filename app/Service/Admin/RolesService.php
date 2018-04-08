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
use App\Service\AdminBase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RolesService extends AdminBase
{

    /***
     * 获取角色列表
     * @return mixed
     */
    public  function  index()
    {
        //redis缓存数据，无则执行数据库获取业务数据
       // return Cache::get('roleList', function() {
            //默认条件
            $list=Role::orderBy('id','asc')->get();
            //结果检测
            if(empty($list))
            {
                responseData(\StatusCode::EMPTY_ERROR,"无结果");
            }
            //写入redis缓存
        //    Cache::put('roleList',$list,config('configure.sCache'));
            //返回数据库层查询结果
            return $list;
    //    });
    }

    /***
     * 角色详情
     * @param $uuid
     * @return mixed
     */
    public function  edit($uuid)
    {
        try{
            //获取详情数据
            $row = Role::where("uuid",$uuid)->first();
            if(empty($row))
            {
                responseData(\StatusCode::EMPTY_ERROR,"请求数据不存在");
            }
        }catch (\ErrorException $e)
        {
            //记录日志
            Log::error('======RolesService-edit:======'. $e->getMessage());
            //业务执行失败
            responseData(\StatusCode::CATCH_ERROR,"获取异常");
        }finally{
            //返回处理结果数据
            return $row;
        }
    }

    /***
     * 新增角色 - 执行
     * @param $data
     */
    public  function  store($data)
    {
        try{
            //开启事务
            DB::beginTransaction();

            //检测name是否存在
            $exist=Role::where("name",$data["name"])->exists();
            if($exist>0)
            {
                responseData(\StatusCode::EXIST_ERROR,"名称".$data["name"]."已存在");
            }

            //业务处理

            //整理新增数据
            $role["uuid"]=create_uuid();
            $role["name"]=$data["name"];
            $role["created_at"]=date("Y-m-d H:i:s");
            //录入数据
            $rs=Role::create($role);

            //结果处理
            if($rs->id!==false)
            {
                DB::commit();
            }else{
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR,"新增失败");
            }
        }catch (\ErrorException $e){
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======RolesService-store:======'. $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR,"新增异常");
        }
    }


    /***
     * 修改角色 - 执行
     * @param $uuid
     */
    public  function  update($uuid,$data)
    {
        try{
            //开启事务
            DB::beginTransaction();

            //业务处理
            //检测存在
            $roleData=Role::where("uuid",$uuid)->first();
            if(empty($roleData))
            {
                responseData(\StatusCode::EXIST_ERROR,"请求数据不存在");
            }

            //检测name是否存在
            if($roleData["name"]!==$data["name"])
            {
                $exist=Role::where("name",$data["name"])->exists();
                if($exist>0)
                {
                    responseData(\StatusCode::EXIST_ERROR,"名称".$data["name"]."已存在");
                }
            }else{
                responseData(\StatusCode::NOT_CHANGE,"名称无变化");
            }

            //整理修改数据
            $role["name"]=$data["name"];
            $role["updated_at"]=date("Y-m-d H:i:s");
            //修改数据
            $rs=Role::where("uuid",$uuid)->update($role);
            //结果处理
            if($rs!==false)
            {
                DB::commit();
            }else{
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR,"修改失败");
            }
        }catch (\ErrorException $e){
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======RolesService-update:======'. $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR,"修改异常");
        }
    }

    /***
     * 删除角色 - 执行
     */
    public  function delete($uuid)
    {
        try{
            //开启事务
            DB::beginTransaction();
            //业务处理
            //检测存在
            $row=Role::where("uuid",$uuid)->first();
            if(empty($row))
            {
                responseData(\StatusCode::EXIST_ERROR,"请求数据不存在");
            }

            //角色
            $roleid=$row->id;

            //不能删除管理员角色
            if($roleid==1)
            {
                responseData(\StatusCode::OUT_ERROR,"不能删除管理员角色");
            }

            //检测角色下是否有对应用户
            $adminExist=AdminUser::where("roleid",$roleid)->exists();
            if($adminExist>0)
            {
                responseData(\StatusCode::EXIST_NOT_DELETE,"角色下关联有用户，不能删除");
            }
            //删除数据
            $rs=Role::where("uuid",$uuid)->delete();
            //结果处理
            if($rs!==false)
            {
                DB::commit();
            }else{
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR,"删除失败");
            }
        }catch (\ErrorException $e){
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======RolesService-delete:======'. $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR,"删除异常");
        }
    }

}