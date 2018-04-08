<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 17:13
 */

namespace App\Http\Middleware;
use App\Model\User\UserToken;
use Closure;
class CheckToken
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        $res = UserToken::where('token',$token)->first();
        if( $res )
        {
            if( $res->expiration <= time() )
            {
                responseData(\StatusCode::TOKEN_ERROR,"token失效");
            }
        }else
        {
            responseData(\StatusCode::REQUEST_ERROR,"非法请求");
        }
        return $next($request);
    }
}