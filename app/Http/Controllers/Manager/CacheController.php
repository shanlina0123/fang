<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:37
 */
namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
class CacheController extends Controller
{


    /***
     * 手动更新缓存
     */
    public function forgetCache()
    {
        //数据源data_select_cate_default 、  renren_data_select_default  增删改的时候手动更新缓存
        Cache::forget("webDatasDefaultAllList");
        Cache::forget("webDatasDefaultList");

        //配置文件web_conf 变化，需手动更新缓存
         Cache::forget("confList");
    }


    public function  homeCache()
    {
        //@舒全刚 看下Admin/UserServie/getList
        //经纪人注册后->需更新缓存
        //经纪人修改找好->需更新缓存
    }
}