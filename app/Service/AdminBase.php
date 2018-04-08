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