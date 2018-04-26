<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/9
 * Time: 10:58
 */

namespace App\Http\Controllers\Home;
use App\Service\Home\LoginOrRegisterService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class LoginOrRegisterController extends HomeBaseController
{

    public  $mod;
    public  $request;
    public function __construct(Request $request, LoginOrRegisterService $mod)
    {
        $this->mod = $mod;
        $this->request = $request;
    }

    /**
     * 注册
     */
    public function register()
    {
        $data = trimValue( $this->request->all() );
        //验证
        $validator = Validator::make(
            $data,
            [
                'nickname' => 'required|max:100',
                'mobile' => 'required|regex:/^1[345789][0-9]{9}$/|unique:user',
                'economictid'=>'required|numeric',
                'wechatopenid'=> 'required|unique:user'
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages );
        }
        $res = $this->mod->registerUser( $data );
        responseData(\StatusCode::SUCCESS,'注册成功', $res );
    }

    /**
     * 登陆
     */
    public function login()
    {
        $data = trimValue( $this->request->all() );
        //验证
        $validator = Validator::make(
            $data,
            [
                'nickname' => 'required|max:100',
                'mobile' => 'required|regex:/^1[345789][0-9]{9}$/',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages );
        }
        $res = $this->mod->checkUser( $data );
        responseData(\StatusCode::SUCCESS,'用户信息', $res );
    }

    /**
     * 获取openid
     */
    public function wxOpenid( $code )
    {
        $wechatConfig = config('configure.wechat');
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$wechatConfig['appid'].'&secret='.$wechatConfig['secret'].'&code='.$code.'&grant_type=authorization_code';
        $data = $this->curlGetDate( $url );
        if( $data )
        {
            if( !array_has($data,'errcode') )
            {
                $obj = new \stdClass();
                $obj->openid = $data['openid'];
                $obj->users = $this->mod->checkUser([],$data['openid']);
                return $obj;
            }else
            {
                responseData(\StatusCode::ERROR,'用户微信授权失败');
            }
        }else
        {
            responseData(\StatusCode::ERROR,'请求微信失败');
        }
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