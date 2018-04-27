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
            return Company::orderBy('created_at','asc')->paginate(config('configure.sPage'));
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
        $obj->mobile = $data['mobile'];
        $obj->conncat = $data['conncat'];
        $obj->addr = $data['addr'];
        $obj->isdefault = 0;
        if( $obj->save() )
        {
            Cache::tags(['companyList','HomeRecommend',"HomeCompanyList"])->flush();

            return 'success';
        }else
        {
            responseData(\StatusCode::ERROR,'添加失败');
        }
    }

    /**
     * @param $uuid
     * @return mixed
     * 公司信息
     */
    public function editCompany( $uuid )
    {
        $res = Company::where('uuid',$uuid)->first();
        if( $res == false )
        {
            responseData(\StatusCode::ERROR,'未查询到公司信息');
        }
        return $res;
    }


    /**
     * @param $data
     * @return string
     * 修改
     */
    public function updateCompany( $data )
    {
        $obj = Company::where('uuid',$data['uuid'])->first();
        if( $obj == false )
        {
            responseData(\StatusCode::ERROR,'未查询到公司信息');
        }

        if( $obj->isdefault == 1 )
        {
            responseData(\StatusCode::ERROR,'默认数据不能修改');
        }
        $obj->name = $data['name'];
        $obj->mobile = $data['mobile'];
        $obj->conncat = $data['conncat'];
        $obj->addr = $data['addr'];
        if( $obj->save() )
        {
            Cache::tags(['companyList','HomeRecommend',"HomeCompanyList"])->flush();
            return 'success';
        }else
        {
            responseData(\StatusCode::ERROR,'修改失败');
        }
    }

    /**
     * @param $uuid
     * @return string
     * 删除
     */
    public function destroyCompany( $uuid )
    {
        $obj = Company::where('uuid', $uuid )->first();
        if( $obj == false )
        {
            responseData(\StatusCode::ERROR,'未查询到公司信息');
        }

        if( $obj->isdefault == 1 )
        {
            responseData(\StatusCode::ERROR,'默认数据不能删除');
        }
        if( $obj->delete() )
        {
            Cache::tags(['companyList','HomeRecommend',"HomeCompanyList"])->flush();
            return 'success';
        }else
        {
            responseData(\StatusCode::ERROR,'删除失败');
        }
    }
}