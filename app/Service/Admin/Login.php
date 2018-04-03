<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;
use App\Service\AdminBase;
use App\Model\User\AdminUser;
use App\Model\User\UserToken;

class Login extends AdminBase
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
        $where['password'] = optimizedSaltPwd(base64_decode($data['password']));
        $user = AdminUser::where( $where )->select('uuid','name','isadmin','mobile','status')->first();
        if( $user->status == 0 )
        {
            return ['status'=>\StatusCode::USER_LOCKING,'messages'=>'用户锁定','data'=>[]];
        }
        if( $user )
        {
            $tWhere['userid'] = $user->id;
            $tWhere['type'] = 1;
            $uToken = UserToken::where( $tWhere )->first();
            if( $uToken )
            {
                $uToken->token = str_random(60);
                $uToken->expiration = time()+7200;
                $uToken->save();
            }else
            {
                $uToken = new UserToken();
                $uToken->uuid = create_uuid();
                $uToken->token = str_random(60);
                $uToken->expiration = time()+7200;
                $uToken->userid = $user->id;
                $uToken->type = 1;
                $uToken->save();
            }
            $user->token = $uToken->token;
            $user->expiration = $uToken->expiration;
            return ['status'=>1,'messages'=>'登陆成功','data'=>$user];
        }else
        {
            return ['status'=>\StatusCode::LOGIN_FAILURE,'messages'=>'登陆成功','data'=>[]];
        }
    }
}