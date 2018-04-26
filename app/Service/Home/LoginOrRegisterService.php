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
use Illuminate\Support\Facades\Log;
class LoginOrRegisterService extends HomeBase
{

    /**
     * @param $data
     * 注册
     */
    public function registerUser( $data )
    {

        $faceimg = (new \WeChat())->getyWechatUserInfo($data['wechatopenid']);
        $obj = new Users();
        $obj->uuid = create_uuid();
        $obj->nickname = $data['nickname'];
        $obj->mobile = $data['mobile'];
        $obj->economictid = $data['economictid'];
        $obj->isadminafter = 0;
        $obj->wechatopenid = $data['wechatopenid'];
        $obj->status = 1;
        //判断用户状态
        if( $faceimg )
        {
            if( array_has($faceimg,'headimgurl') )
            {
                $obj->faceimg = $faceimg?$faceimg['headimgurl']:'';
            }
        }
        if( $obj->save() )
        {
            $tWhere['userid'] = $obj->id;
            $uToken = UserToken::where( $tWhere )->first();
            if( $uToken )
            {
                $uToken->token = str_random(60);
                $uToken->expiration = time()+604800;//7天
                $uToken->save();
            }else
            {
                $uToken = new UserToken();
                $uToken->uuid = create_uuid();
                $uToken->token = str_random(60);
                $uToken->expiration = time()+604800;//7天
                $uToken->userid = $obj->id;
                $uToken->save();
            }
            $obj->token = $uToken->token;
            $obj->expiration = $uToken->expiration;
            return $obj;
        }else
        {
            responseData(\StatusCode::SUCCESS,'注册失败' );
        }
    }


    /**
     * @param $data
     * 登陆
     */
    public function checkUser( $data, $openid=null )
    {
        if( $openid )
        {
            $user = Users::where( 'wechatopenid',$openid )->select('id','uuid','companyid','nickname','name','mobile','economictid','isadminafter','wechatopenid','status','faceimg')->first();
            if( !$user )
            {
                //没有用户信息
                return false;
            }
            if( $user->status != 1 )
            {
                responseData(\StatusCode::USER_LOCKING,'用户锁定');
            }

        }else
        {
            $where['nickname'] = $data['nickname'];
            $where['mobile'] = $data['mobile'];
            $user = Users::where( $where )->select('id','uuid','companyid','nickname','name','mobile','economictid','isadminafter','wechatopenid','status','faceimg')->first();
            if( $user == false )
            {
                responseData(\StatusCode::LOGIN_FAILURE,'用户名密码错误');
            }
            if( $user->status != 1 )
            {
                responseData(\StatusCode::USER_LOCKING,'用户锁定');
            }
        }
        //检测用户图像
        if( !$user->faceimg )
        {
            $faceimg = (new \WeChat())->getyWechatUserInfo($openid);
            //判断用户状态
            if( $faceimg )
            {
                if( array_has($faceimg,'headimgurl') )
                {
                    $user->faceimg = $faceimg['headimgurl'];
                    Users::where( 'wechatopenid',$openid )->update(['faceimg'=>$faceimg['headimgurl']]);
                }
            }
        }
        $tWhere['userid'] = $user->id;
        $uToken = UserToken::where( $tWhere )->first();
        if( $uToken )
        {
            $uToken->token = str_random(60);
            $uToken->expiration = time()+604800;//7天
            $uToken->save();
        }else
        {
            $uToken = new UserToken();
            $uToken->uuid = create_uuid();
            $uToken->token = str_random(60);
            $uToken->expiration = time()+604800;//7天
            $uToken->userid = $user->id;
            $uToken->save();
        }
        $user->token = $uToken->token;
        $user->expiration = $uToken->expiration;
        return $user;
    }

}