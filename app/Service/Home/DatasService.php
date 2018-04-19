<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Home;

use App\Model\Data\Select;
use App\Model\Data\SelectCate;
use App\Model\Data\SelectCateDefault;
use App\Model\Data\SelectDefault;
use App\Service\HomeBase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatasService extends HomeBase
{


    /***
     * 获取数据源列表 所有
     * @return mixed
     */
    public function index()
    {
        //redis缓存数据，无则执行数据库获取业务数据
       // return Cache::get('webDatasAllList', function () {

            //属性分类列表
            $objCateList = SelectCate::select("id", "name")->orderBy('id', 'asc')->get();
            $list = i_array_column($objCateList->toArray(), null, "id");

            //列表
            $objList = Select::where("status", 1)->select("id", "name", "cateid", "created_at")->orderBy('id', 'asc')->get();
            $objList = i_array_column($objList->toArray(), null, "id");

          foreach ($objList as $k => $v) {
               $listAll[$v["cateid"]][] = $v;
          }


            foreach($objCateList as $k=>$v)
            {
                $list[$v["id"]]["_child"]=i_array_column($listAll[$v["id"]],null,"id");
            }


            //整理tree

//            sort($list);
            //结果检测
            if (empty($list)) {
                responseData(\StatusCode::EMPTY_ERROR, "无结果");
            }
            //写入redis缓存
        //    Cache::put('webDatasAllList', $list, config('configure.sCache'));
            //返回数据库层查询结果
          return $list;
        // });
    }

    /***
     * 获取数据源列表 单个分类对应的列表
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
        $list = Select::where(["cateid" => $cateid, "status" => 1])->select("id", "name", "cateid", "created_at")->orderBy('id', 'asc')->get()->toArray();


        $list=i_array_column($list,null,"id");

        //结果检测
        if (empty($list)) {
            responseData(\StatusCode::EMPTY_ERROR, "无结果");
        }
        //返回数据库层查询结果
        return $list;
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
            $row = Select::where("uuid", $uuid)->select("id", "name", "status", "cateid", "created_at")->first();
            if (empty($row)) {
                responseData(\StatusCode::EMPTY_ERROR, "请求数据不存在");
            }

            if ($row["status"] == 0) {
                responseData(\StatusCode::EMPTY_ERROR, "请求数据已禁用");
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
     * 获取默认列表-token验证区分内外部人源客户状态不同
     * @param $isadminafter
     * @return mixed
     */
    public function getDefaultUser($isadminafter)
    {
        //redis缓存数据，无则执行数据库获取业务数据
       // return Cache::get('webDatasDefaultByUserAllList', function () use($isadminafter){

            //属性分类列表

            $objCateList = SelectCateDefault::select("id", "name")->orderBy('id', 'asc')->get();
            $list = i_array_column($objCateList->toArray(), null, "id");
            //列表
            $objList = SelectDefault::select("id", "name", "status", "cateid", "created_at")->orderBy('id', 'asc')->get();
            $objList = i_array_column($objList->toArray(), null, "id");

            //整理tree
            foreach ($objList as $k => $v) {
                //外部经纪人--产品定义暂时屏蔽
//                if($isadminafter==0&&$v["cateid"]==8)
//                {
//                    if(in_array($v["id"],[36,37,40]))
//                    {
//                        $listAll[$v["cateid"]][] = $v;
//                    }
//                }else{
                    $listAll[$v["cateid"]][] = $v;
               // }
            }
            foreach($objCateList as $k=>$v)
            {
                $list[$v["id"]]["_child"]=i_array_column($listAll[$v["id"]],null,"id");
            }

//            foreach ($objList as $k => $v) {
//                $list[$v["cateid"]]["_child"][] = $v;
//            }
//            sort($list);
            //结果检测
            if (empty($list)) {
                responseData(\StatusCode::EMPTY_ERROR, "无结果");
            }
            //写入redis缓存
          //  Cache::put('webDatasDefaultByUserAllList', $list, config('configure.sCache'));
            //返回数据库层查询结果
            return $list;
       // });
    }


    /***
     * 获取单个默认列表-token验证区分内外部人源客户状态不同
     * @return mixed
     */
    public function getDefaultUserOne($cateid,$userid,$isadminafter,$tag="webDatasDefaulUsertList")
    {
        //定义tag的key
        $tagKey = base64_encode(mosaic("", $tag, $cateid,$userid));
        //redis缓存返回
      //  return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($cateid,$isadminafter) {

            //检测cateid是否存在
            $cateExists = SelectCateDefault::where("id", $cateid)->exists();
            if ($cateExists == 0) {
                responseData(\StatusCode::EMPTY_ERROR, "属性分类不存在");
            }

            //默认条件 --产品定义暂时屏蔽
//            if($cateid==8&&$isadminafter==0){
//                $list = SelectDefault::where("cateid", $cateid)
//                    ->whereIn("id", [36,37,40])
//                    ->select("id", "name", "status", "cateid", "created_at")
//                    ->orderBy('id', 'asc')
//                    ->get()
//                    ->toArray();
//            }else{
                $list = SelectDefault::where("cateid", $cateid)->select("id", "name", "status", "cateid", "created_at")->orderBy('id', 'asc')->get()->toArray();
          //  }
            $list=i_array_column($list,null,"id");

            //结果检测
            if (empty($list)) {
                responseData(\StatusCode::EMPTY_ERROR, "无结果");
            }
            //返回数据库层查询结果
            return $list;
      //  });
    }


    /***
     * 获取数据源默认数据列表 所有
     * @return mixed
     */
    public function getDefault()
    {
        //redis缓存数据，无则执行数据库获取业务数据
        return Cache::get('webDatasDefaultAllList', function (){

            //属性分类列表

            $objCateList = SelectCateDefault::select("id", "name")->orderBy('id', 'asc')->get();
            $list = i_array_column($objCateList->toArray(), null, "id");
            //列表
            $objList = SelectDefault::select("id", "name", "status", "cateid", "created_at")->orderBy('id', 'asc')->get();
            $objList = i_array_column($objList->toArray(), null, "id");
            //整理tree
            foreach ($objList as $k => $v) {
                $listAll[$v["cateid"]][] = $v;
            }

            foreach($objCateList as $k=>$v)
            {
                $list[$v["id"]]["_child"]=i_array_column($listAll[$v["id"]],null,"id");
            }
//            foreach ($objList as $k => $v) {
//                $list[$v["cateid"]]["_child"][] = $v;
//            }
//            sort($list);
            //结果检测
            if (empty($list)) {
                responseData(\StatusCode::EMPTY_ERROR, "无结果");
            }
            //写入redis缓存
            Cache::put('webDatasDefaultAllList', $list, config('configure.sCache'));
            //返回数据库层查询结果
            return $list;
        });
    }


    /***
     * 获取数据源列表-默认数据
     * @return mixed
     */
    public function getDefaultOne($cateid,$tag="webDatasDefaultList")
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
            $list=i_array_column($list,null,"id");
            //结果检测
            if (empty($list)) {
                responseData(\StatusCode::EMPTY_ERROR, "无结果");
            }
            //返回数据库层查询结果
            return $list;
        });
    }

}