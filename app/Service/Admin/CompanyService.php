<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;
use App\Model\Company\Company;
use App\Service\AdminBase;
use Illuminate\Support\Facades\Cache;

class CompanyService extends AdminBase
{

    /**
     * @param $request
     * @return mixed
     * 公司列表
     */
    public function getList( $request )
    {
        $tag = 'companyList';
        $where = $request->input('page');
        $value = Cache::tags($tag)->remember( $tag.$where,config('configure.sCache'), function() use( $request ){
            return Company::orderBy('id','desc')->paginate(config('configure.sPage'));
        });
        return $value;
    }

    /**
     * @param $data
     * 添加公司
     */
    public function companySave( $data )
    {
        $obj = new Company();
        $obj->uuid = create_uuid();
        $obj->name = $data['name'];
        if( $obj->save() )
        {
            Cache::tags(['companyList'])->flush();
            return 'success';
        }else
        {
            responseData(\StatusCode::ERROR,'添加失败');
        }
    }
}