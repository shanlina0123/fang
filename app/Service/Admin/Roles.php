<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;
use App\Model\Roles\Role;
use App\Service\AdminBase;
use Illuminate\Support\Facades\Cache;

class Roles extends AdminBase
{

    /***
     * 获取角色列表
     * @return mixed
     */
  public  function  index()
  {
      //redis缓存数据，无则执行数据库获取业务数据
    //  $list = Cache::get('roleList', function() {
          return Role::where('status',1)->orderBy('id','asc')->get();
    //  });
    //  return $list;
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
          $row = Role::where('uuid',$uuid)->first();
      }catch (\ErrorException $e)
      {
          //数据库执行失败
          return responseData(\StatusCode::DB_ERROR,"获取失败");
      }finally{
          //返回处理结果数据
          return $row;
      }


  }
}