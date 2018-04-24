<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;

use App\Model\Data\Select;
use App\Model\Data\SelectCate;
use App\Model\Data\SelectCateDefault;
use App\Model\Data\SelectDefault;
use App\Service\AdminBase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatasService extends AdminBase
{


    /***
     * 获取数据源列表 所有
     * @return mixed
     */
    public function index()
    {
        //redis缓存数据，无则执行数据库获取业务数据
        return Cache::get('datasAllList', function () {
            //属性分类列表
            $objCateList = SelectCate::select("id", "name")->orderBy('id', 'asc')->get();
            $list = i_array_column($objCateList->toArray(), null, "id");

            //列表
            $objList = Select::select("id","uuid", "name", "status", "cateid", "created_at")->orderBy('id', 'asc')->get();
            $objList = i_array_column($objList->toArray(), null, "id");
            //整理tree
            foreach ($objList as $k => $v) {
                $list[$v["cateid"]]["_child"][] = $v;
            }
            sort($list);
            //结果检测
            if (empty($list)) {
                responseData(\StatusCode::EMPTY_ERROR, "无结果");
            }
            //写入redis缓存
            Cache::put('datasAllList', $list, config('configure.sCache'));
            //返回数据库层查询结果
            return $list;
        });
    }

    /***
     * 获取数据源列表
     * @return mixed
     */
    public function getOne($cateid)
    {
        //检测cateid是否存在
        $cateExists = SelectCate::where("id", $cateid)->exists();
        if ($cateExists == 0) {
            responseData(\StatusCode::EMPTY_ERROR, "属性分类不存在");
        }

        //默认条件
        $list = Select::where("cateid", $cateid)->select("id","uuid", "name", "status", "cateid", "created_at")->orderBy('id', 'asc')->get()->toArray();
        //结果检测
        if (empty($list)) {
            responseData(\StatusCode::EMPTY_ERROR, "无结果");
        }
        $list=i_array_column($list,null,"id");
        //返回数据库层查询结果
        return $list;
    }

    /***
     * 获取数据源列表 所有
     * @return mixed
     */
    public function getall()
    {
        //redis缓存数据，无则执行数据库获取业务数据
        return Cache::get('datasWebAllList', function () {
            //属性分类列表
            $objCateList = SelectCate::select("id", "name")->orderBy('id', 'asc')->get();
            $list = i_array_column($objCateList->toArray(), null, "id");
            //结果检测
            if (empty($list)) {
                responseData(\StatusCode::EMPTY_ERROR, "无结果");
            }
            //列表
            $objList = Select::select("id", "name", "cateid", "created_at")->orderBy('id', 'asc')->get();
            $objList = i_array_column($objList->toArray(), null, "id");
            foreach ($objList as $k => $v) {
                $listAll[$v["cateid"]][] = $v;
            }
            foreach($objCateList as $k=>$v)
            {
                $list[$v["id"]]["_child"]=i_array_column($listAll[$v["id"]],null,"id");
            }
            //写入redis缓存
            Cache::put('datasWebAllList', $list, config('configure.sCache'));
            //返回数据库层查询结果
            return $list;
        });
    }

    /***
     * 数据源详情
     * @param $uuid
     * @return mixed
     */
    public function edit($uuid)
    {
        try {
            //获取详情数据
            $row = Select::where("uuid", $uuid)->select("id","uuid", "name", "status", "cateid", "created_at")->first();
            if (empty($row)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在");
            }
        } catch (\ErrorException $e) {
            //记录日志
            Log::error('======DatasService-edit:======' . $e->getMessage());
            //业务执行失败
            responseData(\StatusCode::CATCH_ERROR, "获取异常");
        } finally {
            //返回处理结果数据
            return $row;
        }
    }

    /***
     * 新增数据源 - 执行
     * @param $data
     */
    public function store($data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //检测name是否存在
            $exist = Select::where("name", $data["name"])->exists();
            if ($exist > 0) {
                responseData(\StatusCode::EXIST_ERROR, "名称" . $data["name"] . "已存在");
            }

            //业务处理

            //整理新增数据
            $role["uuid"] = create_uuid();
            $role["cateid"] = $data["cateid"];
            $role["name"] = $data["name"];
            $role["created_at"] = date("Y-m-d H:i:s");
            //录入数据
            $rs = Select::create($role);

            //结果处理
            if ($rs->id !== false) {
                DB::commit();
                //删除缓存
                Cache::forget("datasAllList");
                //删除Home下缓存
                Cache::forget("webDatasAllList");
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "新增失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======DatasService-store:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "新增异常");
        }
        return ["uuid"=>$role["uuid"]];
    }


    /***
     * 修改数据源 - 执行
     * @param $uuid
     */
    public function update($uuid, $data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //业务处理
            //检测存在
            $selectData = Select::where("uuid", $uuid)->first();
            if (empty($selectData)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在");
            }

            //检测name是否存在
            if ($selectData["name"] !== $data["name"]) {
                $exist = Select::where("name", $data["name"])->exists();
                if ($exist > 0) {
                    responseData(\StatusCode::EXIST_ERROR, "名称" . $data["name"] . "已存在");
                }
            } else {
                if ($selectData["cateid"] == $data["cateid"]) {
                    responseData(\StatusCode::NOT_CHANGE, "无变化");
                }

            }

            //整理修改数据
            $select["name"] = $data["name"];
            $select["cateid"] = $data["cateid"];
            $select["updated_at"] = date("Y-m-d H:i:s");
            //修改数据
            $rs = Select::where("uuid", $uuid)->update($select);
            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::forget("datasAllList");
                //删除Home下缓存
                Cache::forget("webDatasAllList");
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "修改失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======DatasService-update:======' . $e->getMessage());
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
            $selectData = Select::where("uuid", $uuid)->first();
            if (empty($selectData)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在");
            }

            //整理修改数据
            $select["status"] = abs($selectData["status"] - 1);
            $select["updated_at"] = date("Y-m-d H:i:s");
            //修改数据
            $rs = Select::where("uuid", $uuid)->update($select);

            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::forget("datasAllList");
                //删除Home下缓存
                Cache::forget("webDatasAllList");

            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "设置失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======DatasService-update:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "设置异常");
        }
    }


    /***
     * 获取数据源默认数据列表 所有
     * @return mixed
     */
    public function getDefault()
    {
        //redis缓存数据，无则执行数据库获取业务数据
        return Cache::get('datasDefaultAllList', function () {

            //属性分类列表
            $objCateList = SelectCateDefault::select("id", "name")->orderBy('id', 'asc')->get();
            $list = i_array_column($objCateList->toArray(), null, "id");

            //列表
            $objList = SelectDefault::select("id", "name", "status", "cateid", "created_at")->orderBy('id', 'asc')->get();
            $objList = i_array_column($objList->toArray(), null, "id");
            foreach ($objList as $k => $v) {
                $listAll[$v["cateid"]][] = $v;
            }

            foreach($objCateList as $k=>$v)
            {
                $list[$v["id"]]["_child"]=i_array_column($listAll[$v["id"]],null,"id");
            }
            //结果检测
            if (empty($list)) {
                responseData(\StatusCode::EMPTY_ERROR, "无结果");
            }
            //写入redis缓存
            Cache::put('datasDefaultAllList', $list, config('configure.sCache'));
            //返回数据库层查询结果
            return $list;
        });
    }


    /***
     * 获取数据源列表-默认数据
     * @return mixed
     */
    public function getDefaultOne($cateid,$tag="datasDefaultList")
    {

        //定义tag的key
        $tagKey = base64_encode(mosaic("", $tag, $cateid));
        //redis缓存返回
        return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($cateid) {

            //检测cateid是否存在
            $cateExists = SelectCateDefault::where("id", $cateid)->exists();
            if ($cateExists == 0) {
                responseData(\StatusCode::EMPTY_ERROR, "属性分类不存在");
            }
            //默认条件
            $list = SelectDefault::where("cateid", $cateid)->select("id", "name", "status", "cateid", "created_at")->orderBy('id', 'asc')->get()->toArray();

            //结果检测
            if (empty($list)) {
                responseData(\StatusCode::EMPTY_ERROR, "无结果");
            }
            $list=i_array_column($list,null,"id");
            //写入redis缓存
            Cache::put('datasDefaultList', $list, config('configure.sCache'));
            //返回数据库层查询结果
            return $list;
        });
    }
    /***
     * 获取自定义分类列表
     */
    public  function  cateList()
    {
            //属性分类列表
             $list = SelectCate::select("id", "name","status")->orderBy('id', 'asc')->get();
            //结果检测
            if (empty($list)) {
                responseData(\StatusCode::EMPTY_ERROR, "无结果");
            }
            //返回数据库层查询结果
            return $list;
    }
}