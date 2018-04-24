<?php
/**
 * CORS route Middleware.
 */

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Closure;

class CorsMiddleware
{
    private $headers;
    private $allow_origin;

    public  function handle($request, Closure $next){

        $this->headers = [
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE',
            'Access-Control-Allow-Headers' => $request->header('Access-Control-Request-Headers'),
            'Access-Control-Allow-Credentials' => 'true',//允许客户端发送cookie
            'Access-Control-Max-Age' => 1728000, //该字段可选，用来指定本次预检请求的有效期，在此期间，不用发出另一条预检请求。
            'X-Content-Type-Options'=> 'nosniff',
            'Expires'=> 'Mon, 26 Jul 1997 05:00:00 GMT',
            'Last-Modified'=> gmdate("D, d M Y H:i:s") . " GMT",
            'Cache-Control'=>'no-cache, must-revalidate',
            'Pragma'=> 'no-cache'
        ];

        // 执行动作
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        $this->allow_origin = config("configure.allow");

        //如果origin不在允许列表内，直接返回403
        if (!in_array($origin, $this->allow_origin) && !empty($origin))
            return new Response('Forbidden', 403);

        if(in_array($origin, $this->allow_origin)){
            header('Access-Control-Allow-Origin:'.$origin);
            header('Access-Control-Allow-Headers:Content-Type, Accept, Authorization, X-Requested-With');
            header('Access-Control-Allow-Methods:POST, GET, OPTIONS, PUT, DELETE, PATCH');
        }

        //如果是复杂请求，先返回一个200，并allow该origin
        if ($request->isMethod('options'))
        {
            return $request;
           //$this->setCorsHeaders(new Response($next($request), 200), $origin);
        }

        //如果是简单请求或者非跨域请求，则照常设置header
        $response = $next($request);
        $methodVariable = array($response, 'header');
        //这个判断是因为在开启session全局中间件之后，频繁的报header方法不存在，所以加上这个判断，存在header方法时才进行header的设置
        if (is_callable($methodVariable, false, $callable_name)) {
            return $response->header('Access-Control-Allow-Origin', $origin);
        }
        return $response;

    }

    /**
     * 设置允许
     * @param $response
     * @return mixed
     */
    public function setCorsHeaders($response, $origin)
    {
        foreach ($this->headers as $key => $value) {
            $response->header($key , $value);
        }
        if (in_array($origin, $this->allow_origin)) {
            $response->header('Access-Control-Allow-Origin', $origin);
        } else {
            $response->header('Access-Control-Allow-Origin', '');
        }
        return $response;
    }
}