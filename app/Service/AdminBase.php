<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:35
 */

namespace App\Service;
use Illuminate\Support\Facades\DB;

class AdminBase
{

    /**
     * 缓存数据
     *---------------------------------------------------------
     *
     * Cache::tags(['clientList'])->flush(); 客户列表
     * Cache::tags(['companyList'])->flush(); 公司列表
     * Cache::forget('getSelect') //房源数据
     * Cache::tags(['houseList'])->flush();房列表
     *
     * //前台
     * Cache::tags(['HomeHouseList'])->flush();房列表
     * Cache::tags(['HomeRecommend'])->flush();首页推荐
     * Cache::tags(['HomeInfo'])->flush();房源详情
     *
     * ---------------------------------------------------------
     *
     */

   public  $tokenInfo;

    /***
     * 初始化
     */
   public  function  _initialize()
   {
       // 开启 log
       DB::connection()->enableQueryLog();

       //获取tokenInfo数据
       $this->tokenInfo=$this->getTokenData();
   }

    /***
     *  token的数据集
     */
   public  function  getTokenData($field)
   {
      $info=["id"=>1,"name"=>"管理员"] ;
      return $field?$info[$field]:$info;
   }

}