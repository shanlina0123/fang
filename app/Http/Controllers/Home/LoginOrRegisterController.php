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
                'wechatopenid'=> 'present'
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
}