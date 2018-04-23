<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;
use App\Model\User\AdminToken;
use App\Service\AdminBase;
use App\Model\User\AdminUser;

class LoginService extends AdminBase
{

    /**
     * @return int
     * 错误信息
     */
    public function errorsMessages()
    {
       $msg = [
           'name.required'=>'用户名不能为空',
           'password.required'=>'密码不能为空'
       ];
       return $msg;
    }

    public function checkUser( $data )
    {
        if( is_numeric($data['name']) )
        {
            $where['mobile'] = $data['name'];
        }else
        {
            $where['name'] = $data['name'];
        }
        $where['password'] = optimizedSaltPwd("admin",base64_decode($data['password']));
        $user = AdminUser::where( $where )->select('id','uuid','name',"nickname", 'isadmin','mobile','status')->first();

        if( $user == false )
        {
            responseData(\StatusCode::LOGIN_FAILURE,'用户名密码错误');
        }
        if( $user->status == 0 )
        {
            responseData(\StatusCode::USER_LOCKING,'用户锁定');
        }

        $tWhere['userid'] = $user->id;
        $uToken = AdminToken::where( $tWhere )->first();
        if( $uToken )
        {
            $uToken->token = str_random(60);
            $uToken->expiration = time()+7200;
            $uToken->save();
        }else
        {
            $uToken = new AdminToken();
            $uToken->uuid = create_uuid();
            $uToken->token = str_random(60);
            $uToken->expiration = time()+7200;
            $uToken->userid = $user->id;
            $uToken->save();
        }
        $user->token = $uToken->token;
        $user->expiration = $uToken->expiration;
        return $user;
    }

    /**
     * @param $uuid
     * @return string
     * 绑openid
     */
    public function checkOpenid( $uuid )
    {
        $res = AdminUser::where('uuid',$uuid)->value('wechatopenid');
        if( $res )
        {
            return 'success';
        }else
        {
            responseData(\StatusCode::ERROR,'未绑定');
        }
    }


    /**
     * @param $data
     * @return mixed
     * 扫码检测状态
     */
    public function checkWechatbackStatus( $data )
    {
        $res = AdminUser::where(['name'=>$data['name'],'wechatbackstatus'=>1])->select(['name','uuid','wechatopenid','wechatbackstatus'])->first();
        if( $res )
        {
            $data = $res;
            $res->wechatbackstatus = 0;
            $res->save();
            return $data;
        }else
        {
            responseData(\StatusCode::ERROR,'未扫码');
        }
    }


    /**
     * @param $data
     * @return string
     * 修改密码
     */
    public function modifyPass( $data )
    {
        $where['name'] = $data['name'];
        $where['wechatopenid'] = $data['wechatopenid'];
        $where['uuid'] = $data['uuid'];
        $res = AdminUser::where( $where )->first();
        if( $res )
        {
            $res->password = optimizedSaltPwd("admin",base64_decode($data['password']));
            if( $res->save() )
            {
                return 'success';
            }else
            {
                responseData(\StatusCode::ERROR,'修改失败');
            }
        }else
        {
            responseData(\StatusCode::ERROR,'未查询到');
        }
    }
}