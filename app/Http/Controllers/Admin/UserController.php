<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Service\Admin\User;
use Illuminate\Http\Request;

class UserController extends AdminBaseController
{
    public  $mod;
    public  $request;
    public function __construct(Request $request, User $mod)
    {
        $this->mod = $mod;
        $this->request = $request;
    }


}