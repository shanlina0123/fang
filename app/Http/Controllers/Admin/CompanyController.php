<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Service\Admin\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends AdminBaseController
{
    public  $company;
    public  $request;
    public function __construct(Request $request, CompanyService $company)
    {
        $this->company = $company;
        $this->request = $request;
    }

    /**
     * 公司列表
     */
    public function index()
    {
        $res = $this->company->getList( $this->request );
        responseData(\StatusCode::SUCCESS,'公司信息列表', $res );
    }

    /**
     * 添加公司
     */
    public function store()
    {
        $data = trimValue( $this->request->all() );
        //验证
        $validator = Validator::make(
            $data,
            [
                'name' => 'required|max:255',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages );
        }
        $res = $this->company->companySave( $data );
        responseData(\StatusCode::SUCCESS,'添加成功', $res );
    }
}
