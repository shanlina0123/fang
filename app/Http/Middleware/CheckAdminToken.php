<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 17:13
 */

namespace App\Http\Middleware;

use App\Model\Data\Functions;
use App\Model\Roles\Role;
use App\Model\Roles\RoleFunction;
use App\Model\User\AdminToken;
use Closure;

class CheckAdminToken
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        $res = AdminToken::where('token', $token)->with('tokenToAdminUser')->first();

        if ($res) {
            $admin = $res->tokenToAdminUser;
            $request->attributes->add(['admin_user' => $admin]);//添加参数
            if ($res->expiration <= time()) {
                responseData(\StatusCode::TOKEN_ERROR, "token失效");
            } else {
                //非管理员验证权限
                if ($admin->isadmin == 0) {
                    //验证权限
                    $this->authRole($admin->roleid);
                }

            }
        } else {
            responseData(\StatusCode::REQUEST_ERROR, "非法请求");
        }
        return $next($request);
    }


    /***
     * 权限验证
     * @param $roleid
     */
    protected function authRole($roleid)
    {
        //角色视野权限
        $authLook = Role::where("id", $roleid)->select("id", "islook", "status")->first();
        if ($authLook->status == 0) {
            responseData(\StatusCode::ROLE_ERROR, "角色已被禁用");
        }


        //当前访问模块
        $route = getControllerOrFunctionName();

        $authFunc = Functions::where(["level" => 3, "controller" => $route["controller"], "action" => $route["action"], "method" => $route["method"]])->select("id")->first();
        $authFuncids = $authFunc->id;
        //未定义该功能
        if (empty($authFuncids)) {
            responseData(\StatusCode::AUTH_NOT_DEFINED_ERROR, "未定义暂未开放");
        }

        //具备的权限功能
        $roleFunc = RoleFunction::where(["roleid" => $roleid, "status" => 1])->select("functionid")->get();
        $roleFunids = array_flatten($roleFunc->toArray());

        //判定是否有权限
        if (!in_array($authFuncids, $roleFunids)) {
            responseData(\StatusCode::AUTH_ERROR, "没有权限");
        }
    }
}