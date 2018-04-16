<?php
/**
 * CORS route Middleware.
 */
namespace App\Http\Middleware;
use App\Model\User\UserToken;
use Closure;

class CorsMiddleware
{
    /***
     * 跨域过滤
     */
    public function handle($request, Closure $next)
    {
        // 执行动作
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

        $allow_origin = config("configure.allow");

        if(in_array($origin, $allow_origin)){
            header('Access-Control-Allow-Origin:'.$origin);
            header('Access-Control-Allow-Headers:Content-Type, Accept, Authorization, X-Requested-With');
            header('Access-Control-Allow-Methods:POST, GET, OPTIONS, PUT, DELETE, PATCH');
        }

        if($request->getMethod() == "OPTIONS") {
            return $request;
        }

        return  $next($request);


    }

}