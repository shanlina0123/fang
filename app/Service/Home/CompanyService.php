<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Home;
use App\Model\Company\Company;
use App\Service\HomeBase;
use Illuminate\Support\Facades\Cache;

class CompanyService extends HomeBase
{
    /***
     * 获取我的客户列表
     * @return mixed
     */
    public function index()
    {
        $tag = 'HomeCompanyList';
        $value = Cache::tags($tag)->remember( $tag,config('configure.sCache'), function(){
           return Company::where("isdefault",0)->orderBy('id','desc')->select('id','name')->get();
        });
        return $value;
    }

}