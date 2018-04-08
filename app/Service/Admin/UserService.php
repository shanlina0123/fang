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
}