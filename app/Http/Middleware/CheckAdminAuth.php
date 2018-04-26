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
use Closure;
use Illuminate\Support\Facades\Log;

class CheckAdminAuth
{
    public function handle($request, Closure $next)
    {
        //获取当前登录用户信息
        $admin_user=$request->get("admin_user");//对象

        //非管理员验证权限
        if ($admin_user->isadmin == 0) {
            if(!$admin_user->roleFunids){
                responseData(\StatusCode::AUTH_NOT_DEFINED_ERROR, "该角色未设定权限，请联系管理员");
            }
            //验证权限
            $this->authRole($admin_user->roleFunids);
        }

        return $next($request);
    }


    /***
     * 权限验证
     * @param $roleFunids  自己具备的功能id
     */
    protected function authRole($roleFunids)
    {
        //当前访问模块
        $route = getControllerOrFunctionName();
        $authFunc = Functions::where(["level" => 2, "controller" => $route["controller"], "action" => $route["action"], "method" => $route["method"]])->select("id")->first();
        //未定义该功能
        if (empty($authFunc)) {
            responseData(\StatusCode::AUTH_NOT_DEFINED_ERROR, "未定义暂未开放");
        }
        $authFuncids = $authFunc->id;

        //判定是否有权限
        if (!in_array($authFuncids, $roleFunids)) {
            responseData(\StatusCode::AUTH_ERROR, "没有权限");
        }
        return $roleFunids;



    }
}