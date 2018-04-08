<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;
use App\Model\User\Users;
use App\Service\AdminBase;

class UserService extends AdminBase
{
   public function getA()
   {
       return 1666;
   }


    /***
     * 获取经纪人列表
     * @return mixed
     */
    public  function  index()
    {
        //redis缓存数据，无则执行数据库获取业务数据
        // return Cache::get('userList', function() {
        //默认条件
        $list=Users::select("uuid","nickname")->orderBy('id','asc')->get();
        //结果检测
        if(empty($list))
        {
            responseData(\StatusCode::EMPTY_ERROR,"无结果");
        }
        //写入redis缓存
        //    Cache::put('userList',$list,config('configure.sCache'));
        //返回数据库层查询结果
        return $list;
        //    });
    }
}