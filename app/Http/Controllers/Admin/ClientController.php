<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin;
use App\Service\Admin\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends AdminBaseController
{
    public  $client;
    public  $request;
    public function __construct(Request $request, ClientService $client)
    {
        $this->client = $client;
        $this->request = $request;
    }

    /**
     * 公司列表
     */
    public function index()
    {
        if( $this->request->get('admin_user') == false )
        {
            responseData(\StatusCode::ERROR,'用户信息丢失' );
        }
        $res = $this->client->getList( $this->request );
        responseData(\StatusCode::SUCCESS,'客户信息', $res );
    }


    /**
     * 删除客户
     */
    public function destroy( $uuid )
    {
        $data['uuid'] = $uuid;
        //验证
        $validator = Validator::make(
            $data,[
                'uuid'=>'required|min:32|max:32',
            ]
        );
        if ($validator->fails())
        {
            $messages = ['uuid'=>'uuid不合法'];
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages);
        }
        $res = $this->client->destroyClient( $uuid, $this->request );
        responseData(\StatusCode::SUCCESS,'删除成功',$res);
    }


    /**
     * @param $uuid
     * 客户信息编辑
     */
    public function edit( $clientid )
    {
        $data['clientid'] = $clientid;
        //验证
        $validator = Validator::make(
            $data,[
                'clientid'=>'required|numeric',
            ]
        );
        if ($validator->fails())
        {
            responseData(\StatusCode::CHECK_FROM,'验证失败','',["clientid"=>["clientid不合法"]]);
        }
        $res = $this->client->editClient( $clientid, $this->request );
        responseData(\StatusCode::SUCCESS,'客户信息',$res);
    }

    /**
     * @param $uuid
     * 修改客户信息
     */
    public function update( $uuid )
    {
        $data = trimValue( $this->request->all() );
        $data['uuid'] = $uuid;
        //验证
        $validator = Validator::make(
            $data,[
                'uuid'=>'required|min:32|max:32',
                'name'=>'required|max:100',
                'comedate'=>'required|date',
                'followstatusid'=>'required|numeric',
                'dealdate'=>'required|date',
                'levelid'=>'required|numeric',
                'houseid'=>'required|numeric',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages);
        }
        $res = $this->client->updateClient( $data, $this->request );
        responseData(\StatusCode::SUCCESS,'编辑成功',$res);
    }

    /**
     * @param $client
     * 跟进客户记录
     */
    public function followEdit( $clientid )
    {
        $res = $this->client->followEditInfo( $clientid, $this->request );
        responseData(\StatusCode::SUCCESS,'跟进记录',$res);
    }


    /**
     * 客户跟进保存
     */
    public function followStore()
    {
        $data = trimValue( $this->request->all() );
        //验证
        $validator = Validator::make(
            $data,[
                'content'=>'present',
                'followstatusid'=>'required|numeric',
                'clientid'=>'required|numeric',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages);
        }
        $res = $this->client->followSave( $data, $this->request );
        responseData(\StatusCode::SUCCESS,'跟进成功',$res);
    }

    /**
     * 客户移交
     */
    public function transferUpdate()
    {
        $data = trimValue( $this->request->all() );
        //验证
        $validator = Validator::make(
            $data,[
                'uuid'=>'required|array',
                'accept'=>'required',//接收人id
                'transfer'=>'required',//移交人id
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors();
            responseData(\StatusCode::CHECK_FROM,'验证失败','',$messages);
        }
        if ( $data['accept'] == $data['transfer'] )
        {
            responseData(\StatusCode::ERROR,'接收人不能和移交人相同');
        }
        $res = $this->client->transferSave( $data, $this->request );
        responseData(\StatusCode::SUCCESS,'移交成功',$res);
    }

    /****
     * 获取房源列表--推荐房源时候模糊搜索的下拉框内容
     */
    public  function  houseData()
    {
        //获取业务数据
        $list=$this->client->houseData();
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

    /***
     * 获取业务员的所有客户
     */
    public  function  getAdminClient($adminid)
    {
        //验证规则
        $validator = Validator::make(["adminid"=>$adminid],[
            "adminid"=>'required|numeric',
        ],[ 'adminid.required'=>'移交人不能为空','adminid.numeric'=>'移交人只能是int类型',]);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }

        $list=$this->client->getAdminClient($adminid);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }
}
