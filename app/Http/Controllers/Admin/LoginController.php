<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Model\User\AdminUser;
use App\Service\Admin\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends AdminBaseController
{
    public  $mod;
    public  $request;
    public  $code;
    public function __construct(Request $request, LoginService $mod)
    {
        $this->mod = $mod;
        $this->request = $request;
    }

    /**
     * 用户登陆
     */
    public function login()
    {
        $data = trimValue( $this->request->all() );
        //验证
        $validator = Validator::make(
            $data,
            [
                'name' => 'required',
                'password' => 'required|min:4',
            ],
            $this->mod->errorsMessages()
        );
        if ($validator->fails())
        {
            $messages = $validator->errors();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages );
        }
        $res = $this->mod->checkUser( $data );
        responseData(\StatusCode::SUCCESS,'登陆成功', $res );
    }


    /**
     * 检测是否绑定
     */
    public function binding( $uuid )
    {
        $validator = Validator::make(
            ['uuid'=>$uuid],
            [
                'uuid' => 'required|min:32|max:32',
            ]
        );
        if ($validator->fails())
        {
            responseData(\StatusCode::CHECK_FROM,'验证失败','',['uuid'=>'uuid不合法'] );
        }
        $res = $this->mod->checkOpenid( $uuid );
        responseData(\StatusCode::SUCCESS,'绑定成功', $res );
    }


    /**
     * 检测号码结果
     */
    public function testing()
    {
        $data = trimValue( $this->request->all() );
        //验证
        $validator = Validator::make(
            $data,
            [
                'uuid' => 'required',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages );
        }
        $res = $this->mod->checkWechatbackStatus( $data );
        responseData(\StatusCode::SUCCESS,'登陆成功', $res );
    }


    /**
     * 修改密码
     */
    public function modifyPass()
    {
        $data = trimValue( $this->request->all() );
        //验证
        $validator = Validator::make(
            $data,
            [
                'wechatopenid' => 'required',
                'uuid' => 'required',
                'password' => 'required|min:6|max:12',
                'confirmed' => 'password_confirmation',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages );
        }
        $res = $this->mod->modifyPass( $data );
        responseData(\StatusCode::SUCCESS,'修改成功', $res );
    }


    /**
     * 检测用户名称
     */
    public function getUser( Request $request )
    {
        $name = $request->input('name');
        if( $name )
        {
            $res = AdminUser::where('name',trim( $name) )->first();
            if( $res )
            {
                responseData(\StatusCode::SUCCESS,'检测成功',$res->uuid);
            }
        }

        responseData(\StatusCode::ERROR,'用户不存在');
    }

}
