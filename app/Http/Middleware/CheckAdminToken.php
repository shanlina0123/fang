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
        if(empty($token))
        {
            responseData(\StatusCode::TOKEN_EMPTY,"token为空");
        }
        $res = AdminToken::where('token', $token)->with('tokenToAdminUser')->first();
        if ($res) {
            $admin = $res->tokenToAdminUser;
            if ($res->expiration <= time()) {
                responseData(\StatusCode::TOKEN_ERROR, "token失效");
            }
        } else {
            responseData(\StatusCode::REQUEST_ERROR, "非法请求");
        }

        //非管理员已有的功能id
        if($admin->isadmin==0)
        {
            $roleid=$admin->roleid;
            //角色视野权限
            $authLook = Role::where("id", $roleid)->select("id", "islook", "status")->first();
            if ($authLook->status == 0) {
                responseData(\StatusCode::ROLE_ERROR, "角色已被禁用");
            }
            $admin["islook"]=$authLook["islook"];
            //具备的权限功能
            $roleFuncObj = RoleFunction::where(["roleid" => $roleid, "status" => 1])->select("functionid")->get();
            $admin["roleFunids"] = array_flatten($roleFuncObj->toArray());
        }else{
            $admin["islook"]=0;
            $admin["roleFunids"]=[];
        }
        $request->attributes->add(['admin_user' => $admin]);//添加参数
        return $next($request);
    }

}