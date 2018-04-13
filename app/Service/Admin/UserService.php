<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;
use App\Model\User\AdminUser;
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
            $userData = Users::where("uuid", $uuid)->first();
            if (empty($userData)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在");
            }

            //整理修改数据
            $admin["status"] = abs($userData["status"] - 1);
            $admin["updated_at"] = date("Y-m-d H:i:s");
            //修改数据
            $rs = Users::where("uuid", $uuid)->update($admin);

            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::tags(['brokerList'])->flush();
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "设置失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======UserService-setting:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "设置异常");
        }
    }


    /**
     * @param $request
     * 修改密码
     */
    public function updatePass( $request,$data )
    {
        $admin_user = $request->get('admin_user');
        $res = AdminUser::where('id',$admin_user->id)->first();
        $res->password = optimizedSaltPwd("admin",base64_decode($data['password']));
        if( $res->save() )
        {
            return 'success';
        }else
        {
            responseData(\StatusCode::ERROR,'修改失败');
        }
    }
}