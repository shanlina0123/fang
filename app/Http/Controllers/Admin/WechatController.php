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
//use Illuminate\Support\Facades\Log;
class WechatController extends AdminBaseController
{


    public $appid;
    public $secret;
    static $TOKEN = '30b06afa212356';
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
        if( $token == static::$TOKEN  )
        {
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
                //$this->responseMsg();
            }
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

                //拿到openid
                if( Cache::has('authorization_token'.$uid ) )
                {
                    //获取openid
                    $openid = Cache::get('authorization_token'.$uid )['openid'];

                }elseif(  Cache::has('authorization_refresh'.$uid ) )
                {
                    $data = $this->refreshToken( Cache::get('authorization_refresh'.$uid ), $uid );
                    if( $data )
                    {
                        $openid = $data['openid'];

                    }else
                    {
                        $data = $this->getAccessToken( $code, $uid );
                        if( $data )
                        {
                            $openid = $data['openid'];
                        }else
                        {
                            responseData(\StatusCode::ERROR,'授权失败未获取到openid');
                        }
                    }
                }else
                {
                    //请求
                    $data = $this->getAccessToken( $code, $uid );
                    if( $data )
                    {
                        $openid = $data['openid'];
                    }else
                    {
                        responseData(\StatusCode::ERROR,'授权失败未获取到openid');
                    }

                }
                //用openid 和全局token换取用户信息
                $weChat = new \WeChat();
                $weChatUserInfo = $weChat->getyWechatUserInfo($openid);
                if( !$weChatUserInfo )
                {
                    responseData(\StatusCode::ERROR,'授权失败未获取到用户信息');
                }
                //未关注
                if( $weChatUserInfo['subscribe'] == 0 )
                {
                    responseData(\StatusCode::ERROR,'授权失败请先关注公众号');
                }
                //后台用户
                $res = AdminUser::find( $uid );
                $res->wechatopenid = $weChatUserInfo['openid'];
                $res->wechatbackstatus = 1;
                $res->save();
                //前端用户
                $user = Users::where('adminid',$uid)->first();
                if( $uid )
                {
                    $user->wechatopenid = $weChatUserInfo['openid'];
                    $user->faceimg = $weChatUserInfo['headimgurl'];
                    $user->save();
                }
                DB::commit();
                responseData(\StatusCode::SUCCESS,'授权成功',['subscribe'=>$weChatUserInfo['subscribe']] );
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
            //存储token信息
            Cache::put('authorization_token'.$uid, $data, $data['expires_in']/60);
            //存储refreshToken信息
            Cache::put('authorization_refresh'.$uid, $data, 43200);
            return $data;
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
        try{
            $res_url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$this->appid.'&grant_type=refresh_token&refresh_token='.$data['refresh_token'];
            $res = $this->curlGetDate( $res_url );
            if( !array_has($res,'errcode') )
            {
                //存储refreshToken信息
                Cache::put('authorization_refresh'.$uid, $res, 43200);
                //存储新的用户信息
                Cache::put('authorization_token'.$uid, $res, $res['expires_in']/60);
                return $res;
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
     * 静默授权是直接获取不到用户信息的
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
            //拿到openid
            if( Cache::has('authorization_token'.$user->id ) )
            {
                //获取openid
                $openid = Cache::get('authorization_token'.$user->id )['openid'];

            }elseif(  Cache::has('authorization_refresh'.$user->id ) )
            {
                $data = $this->refreshToken( Cache::get('authorization_refresh'.$user->id ), $user->id );
                if( $data )
                {
                    $openid = $data['openid'];
                }else
                {
                    $data = $this->getAccessToken( $code, $user->id );
                    if( $data )
                    {
                        $openid = $data['openid'];
                    }else
                    {
                        responseData(\StatusCode::ERROR,'授权失败未获取到openid');
                    }
                }
            }
            if( $openid )
            {
                if( $openid == $user->wechatopenid )
                {
                    $user->wechatbackstatus = 1;
                    $user->save();
                    responseData(\StatusCode::SUCCESS,'扫码成功');
                }else
                {
                    responseData(\StatusCode::SUCCESS,'您还未绑定微信');
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
        return json_decode($output,true);
    }
}
