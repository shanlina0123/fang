<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/9
 * Time: 11:00
 */

namespace App\Service\Home;
use App\Model\User\Users;
use App\Model\User\UserToken;
use App\Service\HomeBase;
class LoginOrRegisterService extends HomeBase
{

    /**
     * @param $data
     * 注册
     */
    public function registerUser( $data )
    {
        $obj = new Users();
        $obj->uuid = create_uuid();
        $obj->nickname = $data['nickname'];
        $obj->mobile = $data['mobile'];
        $obj->economictid = $data['economictid'];
        $obj->isadminafter = 0;
        $obj->wechatopenid = $data['wechatopenid'];
        $obj->status = 1;
        if( $obj->save() )
        {
            return 'success';

        }else
        {
            responseData(\StatusCode::SUCCESS,'注册失败' );
        }
    }


    /**
     * @param $data
     * 登陆
     */
    public function checkUser( $data )
    {
        $where['nickname'] = $data['nickname'];
        $where['mobile'] = $data['mobile'];
        $user = Users::where( $where )->select('id','uuid','companyid','nickname','name','mobile','economictid','isadminafter','wechatopenid','status')->first();
        if( $user == false )
        {
            responseData(\StatusCode::LOGIN_FAILURE,'用户名密码错误');
        }
        if( $user->status != 1 )
        {
            responseData(\StatusCode::USER_LOCKING,'用户锁定');
        }
        $tWhere['userid'] = $user->id;
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
            $uToken->save();
        }
        $user->token = $uToken->token;
        $user->expiration = $uToken->expiration;
        return $user;
    }

}