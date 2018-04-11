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
use Illuminate\Support\Facades\Cache;


class UserService extends AdminBase
{

    /**
     * @param $request
     * @return mixed
     * 经纪人列表
     */
   public function getList( $request )
   {
       $tag = 'brokerList';
       $where = $request->input('page').$request->input('companyid').$request->input('economictid');
       $value = Cache::tags($tag)->remember( $tag.$where,config('configure.sCache'), function() use( $request ){
           $sql = Users::orderBy('id','desc');
           if( $request->input('companyid') )
           {
               $sql->where('companyid',$request->input('companyid'));
           }
           if( $request->input('economictid') )
           {
               $sql->where('economictid',$request->input('economictid'));
           }
           return $sql->paginate(config('configure.sPage'));
       });
       return $value;
   }


    /***
     * 获取经纪人列表
     * @return mixed
     */
    public  function  index()
    {
        //默认条件
        $list=Users::select("id","nickname","isadminafter")->orderBy('id','asc')->get();

        $list=array_to_parent($list->toArray(),"id","isadminafter");
        //结果检测
        if(empty($list))
        {
            responseData(\StatusCode::EMPTY_ERROR,"无结果");
        }
        //返回数据库层查询结果
        return $list;
    }
}