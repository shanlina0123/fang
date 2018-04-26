<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Model\User\AdminToken;
use App\Model\User\AdminUser;
use App\Model\User\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class WechatController extends AdminBaseController
{


    public $appid;
    public $secret;
    static $TOKEN = '30b06afa21235689666220154e1adc540fa';
    public function __construct()
    {
        $wechatConfig = config('configure.wechat');
        $this->appid = $wechatConfig['appid'];
        $this->secret = $wechatConfig['secret'];
    }

    /**
     * @return mixed
     * 请求入口
     */
    public function index( Request $request )
    {
        $token = $request->input('token');
        if( $request->method() == "GET" || $request->method() == "get" )
        {
            $echoStr = $request->input('echostr');
            if( $this->checkSignature( $request,static::$TOKEN ) )
            {
                echo $echoStr;
                exit;
            }

        }else
        {
            $this->responseMsg();
        }

    }

    /**
     * @param $request
     * @param $token
     * @return bool.
     * 验证
     */
    private function checkSignature( $request,$token )
    {
        $signature = $request->input('signature');
        $timestamp = $request->input('timestamp');
        $nonce = $request->input('nonce');
        $token = $token;
        $tmpArr = array($token, $timestamp, $nonce );
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature )
        {
            return true;
        }else
        {
            return false;
        }
    }


    /**
     * @param Request $request
     * 接受code获取换取token
     */
    public function authorization( Request $request )
    {
        $token = $request->input('token');
        $code = $request->input('code');
        $uid = AdminToken::where('token', $token)->value('userid');
        if( $uid )
        {
            try{

                DB::beginTransaction();
                if( Cache::has('authorization'.$uid ) )
                {
                    $data = $this->refreshToken( Cache::get('authorization'.$uid ), $uid );

                }else
                {
                    $data = $this->getAccessToken( $code, $uid );
                }
                //后台用户
                $res = AdminUser::find( $uid );
                $res->wechatopenid = $data->openid;
                $res->wechatbackstatus = 1;
                $res->save();
                //前端用户
                $user = Users::where('adminid',$uid)->first();
                if( $uid )
                {
                    $user->wechatopenid = $data->openid;
                    $user->faceimg = $data->headimgurl;
                    $user->save();
                }
                DB::commit();
                responseData(\StatusCode::SUCCESS,'授权成功');
            }catch (Exception $e)
            {
                DB::rollBack();
                responseData(\StatusCode::ERROR,'授权失败');
            }
        }
    }

    /**
     * @param $code
     * @return bool|mixed
     * 得到token和openid
     */
    public function getAccessToken( $code, $uid )
    {
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->secret.'&code='.$code.'&grant_type=authorization_code';
        $data = $this->curlGetDate( $url );
        if( !array_has($data,'errcode') )
        {
            $data = json_encode( $data );
            //存储token信息
            Cache::put('authorization'.$uid, $data, 43200);
            //获取用户信息
            return $this->getUserInfo( $data );

        }else
        {
            return false;
        }
    }


    /**
     * @return bool
     * 刷新token
     */
    public function refreshToken( $data, $uid )
    {
        $data = json_decode($data);
        try{
            $res_url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$this->appid.'&grant_type=refresh_token&refresh_token='.$data->refresh_token;
            $res = $this->curlGetDate( $res_url );
            if( !array_has($res,'errcode') )
            {
                $res = json_encode( $res );
                //存储token信息
                Cache::put('authorization'.$uid, $res, 43200);
                //获取用户信息
                return $this->getUserInfo( $res );

            }else
            {
                return false;
            }
        }catch (\Exception $e)
        {
            return false;
        }
    }


    /**
     * @param $data
     * @return mixed
     * 用户信息
     */
    public function getUserInfo( $data )
    {
        $data = json_decode($data);
        $access_token = $data->access_token;
        $openid = $data->openid;
        $user = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        $obj = $this->curlGetDate( $user );
        return $obj;

    }


    /**
     * @param Request $request
     * 密码扫码
     */
    public function forget( Request $request )
    {
        $name = $request->input('uuid');
        $code = $request->input('code');
        $user = AdminUser::where('uuid', $name)->first();
        if( $user )
        {

            if( Cache::has('authorization'.$user->id ) )
            {

                $data = $this->refreshToken( Cache::get('authorization'.$user->id ), $user->id );

            }else
            {
                $data = $this->getAccessToken( $code, $user->id );
            }

            if( $data )
            {
                if( $data->openid == $user->wechatopenid )
                {
                    $user->wechatbackstatus = 1;
                    $user->save();
                    responseData(\StatusCode::SUCCESS,'扫码成功');
                }
            }
            responseData(\StatusCode::ERROR,'授权失败');

        }
        responseData(\StatusCode::ERROR,'信息不存在');
    }



    /**
     * @param $url
     * @return mixed
     * curl get请求
     */
    public function curlGetDate( $url )
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output);
    }
}
