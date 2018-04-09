<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Home;
use App\Http\Model\User\User;
use App\Model\User\Users;
use App\Service\HomeBase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UsersService extends HomeBase
{


    /***
     * 获取用户信息
     * @return mixed
     */
    public  function  index($userid)
    {
        //redis缓存数据，无则执行数据库获取业务数据
        // return Cache::get('confList', function() {
        //列表
        $list=Users::where("id",$userid)->select("nickname","economictid","mobile","faceimg")->orderBy('id','asc')->get();
        //结果检测
        if(empty($list))
        {
            responseData(\StatusCode::EMPTY_ERROR,"无结果");
        }
        //写入redis缓存
        //    Cache::put('confList',$list,config('configure.sCache'));
        //返回数据库层查询结果
        return $list;
        //    });
    }

    /***
     * 修改用户 - 执行
     * @param $uuid
     */
    public  function  update($userinfo,$data)
    {
        try{
            //开启事务
            DB::beginTransaction();

            //检测手机号是否被占用
            if($userinfo["mobile"]!==$data["mobile"])
            {
                $existMobile=User::where("mobile",$data["mobile"])->exists();
                if($existMobile>0)
                {
                    responseData(\StatusCode::EXIST_ERROR,"手机号".$data["mobile"]."已存在");
                }
            }else{
                responseData(\StatusCode::EXIST_ERROR,"无变化");
            }

            //业务处理
            //整理修改数据
            $userUpdate["mobile"]=$data["mobile"];
            $userUpdate["updated_at"]=date("Y-m-d H:i:s");
            //修改User数据
            $rs=User::where("id",$userinfo["id"])->update($userUpdate);
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
            Log::error('======UsersService-update:======'. $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR,"修改异常");
        }
    }
}