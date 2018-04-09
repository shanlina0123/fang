<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;
use App\Model\Client\Client;
use App\Model\Client\ClientDispatch;
use App\Model\Client\ClientDynamic;
use App\Model\Client\ClientFollow;
use App\Model\Client\ClientTransfer;
use App\Service\AdminBase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ClientService extends AdminBase
{

    /**
     * @param $request
     * @return mixed
     * 列表
     */
    public function getList( $request )
    {
        $tag = 'clientList';
        $adminID = $request->get('admin_user')->id;
        $where = $adminID.$request->input('page').$request->input('followstatusid').$request->input('housename').$request->input('levelid').$request->input('ownuserid');
        $where = base64_encode($where);
        $value = Cache::tags($tag)->remember( $tag.$where,config('configure.sCache'), function() use( $request ){
            //用户信息
            $admin_user = $request->get('admin_user');
            $sql = ClientDynamic::orderBy('id','desc')->with('dynamicToClient');
            //管理员
            if(  $admin_user->isadmin == 1 )
            {
                if( $request->input('ownuserid') )
                {
                    $sql->where('ownuserid',$request->input('ownuserid'));
                }
            }else
            {
                $sql->where('ownuserid', $admin_user->id);
            }
            //客户跟进状态
            if( $request->input('followstatusid') )
            {
                $sql->where('followstatusid',$request->input('followstatusid'));
            }
            //客户等级
            if( $request->input('levelid') )
            {
                $sql->where('levelid',$request->input('levelid'));
            }
            //楼盘名称
            if( $request->input('housename') )
            {
                $sql->where('housename','like',$request->input('housename'));
            }
            return  $sql->paginate(config('configure.sPage'));
        });
        return $value;
    }

    /**
     * @param $uuid
     * 客户删除
     */
    public function destroyClient( $uuid, $request )
    {
        try{
            DB::beginTransaction();
            $admin_user = $request->get('admin_user');
            if(  $admin_user->isadmin == 1 )
            {
                $where['uuid'] = $uuid;
            }else
            {
                $where['uuid'] = $uuid;
                $where['ownuserid'] = $admin_user->id;
            }
            $res = ClientDynamic::where($where)->first();
            if( $res )
            {
                //用户
                Client::where('id',$res->clientid)->delete();
                //派单记录
                ClientDispatch::where('clientid',$res->clientid)->delete();
                //移交记录
                ClientTransfer::where('clientid',$res->clientid)->delete();
                //跟进记录
                ClientFollow::where('clientid',$res->clientid)->delete();
                //详情
                $res->delete();
            }else
            {
                responseData(\StatusCode::ERROR,'未擦查询到用户信息');
            }
            DB::commit();
            //清除缓存
            Cache::tags(['clientList'])->flush();
            return 'success';
        }catch (Exception $e){
            DB::rollBack();
            responseData(\StatusCode::ERROR,'删除失败');
        }
    }

    /**
     * @param $uuid
     * 客户信息编辑页
     */
    public function editClient( $uuid, $request )
    {
        $admin_user = $request->get('admin_user');
        if(  $admin_user->isadmin == 1 )
        {
            $where['uuid'] = $uuid;
        }else
        {
            $where['uuid'] = $uuid;
            $where['ownuserid'] = $admin_user->id;
        }
        $res = ClientDynamic::orderBy('id','desc')->with('dynamicToClient')->first();
        if( $res )
        {
            $obj = new \stdClass();
            $obj->uuid = $res->uuid;
            $obj->name = $res->dynamicToClient?$res->dynamicToClient->name:'';
            $obj->mobile = $res->dynamicToClient?$res->dynamicToClient->mobile:'';
            $obj->makedate = $res->makedate;
            $obj->comedate = $res->comedate;
            $obj->followstatusid = $res->followstatusid;
            $company = $res->companyid;
            if( $company )
            {
                $obj->company = $res->dynamicToCompany?$res->dynamicToCompany->name:'';

            }else
            {
                $obj->company = $res->dynamicToClient?$res->dynamicToClient->remark:'';
            }
            $obj->refereeusername = $res->dynamicToUser?$res->dynamicToUser->nickname:'';
            $obj->followname = $res->dynamicToClient?$res->dynamicToClient->name:'';
            $obj->followcount = $res->followcount;
            $obj->followdate = $res->followdate;
            $obj->dealdate = $res->dealdate;
            $obj->levelid = $res->levelid;
            return $obj;
        }else
        {
            responseData(\StatusCode::ERROR,'未查询到客户信息' );
        }
    }


    /**
     * @param $data
     * 编辑客户信息
     */
    public function updateClient( $data, $request )
    {
        $admin_user = $request->get('admin_user');
        if(  $admin_user->isadmin == 1 )
        {
            $where['uuid'] = $data['uuid'];
        }else
        {
            $where['uuid'] = $data['uuid'];
            $where['ownuserid'] = $admin_user->id;
        }
        $obj = ClientDynamic::orderBy('id','desc')->with('dynamicToClient')->first();
        if( $obj )
        {
            try{
                DB::beginTransaction();
                $obj->comedate = $data['comedate'];
                $obj->dealdate = $data['dealdate'];
                $obj->levelid =  $data['levelid'];
                $obj->save();
                $obj->dynamicToClient->update(['name'=>$data['name']]);
                DB::commit();
                return 'success';
            }catch (Exception $e){
                DB::rollBack();
                responseData(\StatusCode::ERROR,'编辑失败');
            }
        }else
        {
            responseData(\StatusCode::ERROR,'未查询到客户信息' );
        }
    }


    /**
     * 跟进客户
     */
    public function followEditInfo( $client, $request  )
    {
        $admin_user = $request->get('admin_user');
        if(  $admin_user->isadmin == 1 )
        {
            $where['uuid'] = $client;
        }else
        {
            $where['uuid'] = $client;
            $where['ownuserid'] = $admin_user->id;
        }
        $obj = ClientFollow::orderBy('id','desc')->get();
        if( $obj )
        {
            return $obj;

        }else
        {
            responseData(\StatusCode::ERROR,'未查询到客户信息' );
        }
    }


    /**
     * @param $data
     * @param $request
     * @return string
     * 保存跟进
     */
    public function followSave( $data, $request )
    {
        try{
            DB::beginTransaction();
            $obj = new ClientFollow();
            $obj->uuid = create_uuid();
            $obj->clientid = $data['clientid'];
            $obj->followstatusid = $data['followstatusid'];
            $obj->content = $data['content'];
            $obj->userid = $request->get('admin_user')->id;
            $obj->save();
            $dynamic = ClientDynamic::where('clientid',$data['clientid'])->first();
            $dynamic->followstatusid = $data['followstatusid'];
            $dynamic->followcount = $dynamic->followcount+1;
            $dynamic->followdate = date('Y-m-d H:i:s');
            DB::commit();
            return 'success';
        }catch (Exception $e)
        {
            DB::rollBack();
            responseData(\StatusCode::ERROR,'跟进失败');
        }
    }

    /**
     *  客户移交
     */
    public function transferSave( $data )
    {
        try{

            $res = ClientDynamic::whereIn('uuid',$data['uuid'])->get();
            $dispatch = array();
            $transfer = array();
            foreach ( $res as $row )
            {
                //派单记录
                $dispatch[]['uuid'] = create_uuid();
                $dispatch[]['clientid'] = $row->clientid;
                $dispatch[]['type'] = 3;
                $dispatch[]['remark'] = '移交派单';
                $dispatch[]['userid'] = $data['accept'];
                $dispatch[]['created_at'] = date('Y-m-d H:i:s');
                //移交记录
                $transfer[]['uuid'] = create_uuid();
                $transfer[]['clientid'] = $row->clientid;
                $transfer[]['beforeownuserid'] = $row->ownuserid;
                $transfer[]['afterownuserid'] = $data['transfer'];
                $transfer[]['remark'] = '客户移交';
                $transfer[]['created_at'] = date('Y-m-d H:i:s');
            }
            //写入派单记录
            ClientDispatch::insert($dispatch);
            //写入移交记录
            ClientTransfer::insert($transfer);
            //修改客户表
            ClientDynamic::whereIn('uuid',$data['uuid'])->update(['ownuserid'=>$data['accept']]);
            DB::commit();
            //清除缓存
            Cache::tags(['clientList'])->flush();
            return 'success';
        }catch (Exception $e){
            DB::rollBack();
            responseData(\StatusCode::ERROR,'编辑失败');
        }
    }
}