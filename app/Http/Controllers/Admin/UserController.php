<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Service\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends AdminBaseController
{
    public  $mod;
    public  $request;
    public function __construct(Request $request, UserService $mod)
    {
        $this->mod = $mod;
        $this->request = $request;
    }


    /**
     * 经纪人列表
     */
    public function broker()
    {
        $res = $this->mod->getList( $this->request );
        responseData(\StatusCode::SUCCESS,'经纪人列表', $res );
    }
}