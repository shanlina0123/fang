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
use App\Model\House\House;
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
        //用户信息
        $admin_user = $request->get('admin_user');
        $adminID = $admin_user->id;
        $isAdmin=$admin_user->isadmin;
        $where = $adminID.$isAdmin.$request->input('page').$request->input('followstatusid').$request->input('housename').$request->input('levelid').$request->input('ownuserid');
        $where = base64_encode($where);
      // $value = Cache::tags($tag)->remember( $tag.$where,config('configure.sCache'), function() use( $request,$admin_user ){

            $sql = ClientDynamic::orderBy('id','desc')->with('dynamicToClient');

            //管理员
            if($admin_user->isadmin == 1 )
            {
                if( $request->input('ownadminid') )
                {
                    $sql->where('ownadminid',$request->input('ownadminid'));
                }
            }else
            {
                $sql->where('ownadminid', $admin_user->id);
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
            $housename=searchFilter($request->input('housename'));
            //楼盘名称
            if( $request->input('housename') )
            {
                $sql->where('housename','like',"%".$housename."%");
            }




            return  $sql->with("dynamicToCompany","dynamicToUser")->paginate(config('configure.sPage'));
       //  });
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
                $where['ownadminid'] = $admin_user->id;
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
    public function editClient( $clientid, $request )
    {
        $admin_user = $request->get('admin_user');
        if(  $admin_user->isadmin == 1 )
        {
            $where['clientid'] = $clientid;
        }else
        {
            $where['clientid'] = $clientid;
            $where['ownadminid'] = $admin_user->id;
        }
        $res = ClientDynamic::where($where)->orderBy('id','desc')->with('dynamicToClient')->first();
        if( $res )
        {
            $obj = new \stdClass();
            $obj->uuid = $res->uuid;
            $obj->name = $res->dynamicToClient?$res->dynamicToClient->name:'';
            $obj->mobile = $res->dynamicToClient?$res->dynamicToClient->mobile:'';
            $obj->makedate =$res->makedate?date("Y-m-d",strtotime($res->makedate)):"";
            $obj->comedate =$res->makedate?date("Y-m-d",strtotime($res->comedate)):"";
            $obj->followstatusid = $res->followstatusid;
            $company = $res->companyid;
            if( $company )
            {
                $obj->company = $res->dynamicToCompany?$res->dynamicToCompany->name:'';

            }else
            {
                $obj->company = $res->dynamicToClient?$res->dynamicToClient->remark:'';
            }
            $obj->refereeusername = $res->dynamicToUser?$res->dynamicToUser->nickname:'';//经纪人
            $obj->followname = $res->dynamicToAdminUser?$res->dynamicToAdminUser->nickname:'';//跟进人名称
            $obj->houseid=$res->houseid;
            $obj->housename=$res->housename;
            $obj->followcount = $res->followcount;
            $obj->followdate =$res->followdate?date("Y-m-d",strtotime($res->followdate)):date("Y-m-d");
            $obj->dealdate =$res->dealdate?date("Y-m-d",strtotime($res->dealdate)):"";

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

        //检测楼盘id是否存在
        $houseData=House::where("id",$data["houseid"])->first();
        if(empty($houseData))
        {
            responseData(\StatusCode::NOT_EXIST_ERROR,'楼盘信息不存在' );
        }

        $admin_user = $request->get('admin_user');
        if(  $admin_user->isadmin == 1 )
        {
            $where['uuid'] = $data['uuid'];
        }else
        {
            $where['uuid'] = $data['uuid'];
            $where['ownadminid'] = $admin_user->id;
        }
        $obj = ClientDynamic::where($where)->orderBy('id','desc')->with('dynamicToClient')->first();
        if( $obj )
        {
            try{
                DB::beginTransaction();
                $obj->comedate = $data['comedate'];
                $obj->dealdate = $data['dealdate'];
                $obj->levelid =  $data['levelid'];
                $obj->houseid =  $houseData['id'];
                $obj->housename =  $houseData['name'];
                $obj->save();
                $obj->dynamicToClient->update(['name'=>$data['name']]);
                DB::commit();
                Cache::tags(['clientList'])->flush();
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
    public function followEditInfo( $uuid, $request  )
    {
        $admin_user = $request->get('admin_user');
        if(  $admin_user->isadmin == 1 )
        {
            $where['uuid'] = $uuid;
        }else
        {
            $where['uuid'] = $uuid;
            $where['ownadminid'] = $admin_user->id;
        }
        $obj = ClientFollow::orderBy('id','desc')->with('followToAdminUser')->get();
        if( $obj )
        {
            $arr = array();
            foreach ( $obj as $row )
            {
                $rowObj = new \stdClass();
                $rowObj->followstatusid = $row->followstatusid;
                $rowObj->content = $row->content;
                $rowObj->time = $row->created_at?date_format($row->created_at,date("Y-m-d")):'';
                $rowObj->username = $row->followToAdminUser?$row->followToAdminUser->nickname:'';
                $arr[] = $rowObj;
            }
            return $arr;

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
            $obj->adminid = $request->get('admin_user')->id;
            $obj->save();
            $dynamic = ClientDynamic::where('clientid',$data['clientid'])->first();
            $dynamic->followstatusid = $data['followstatusid'];
            $dynamic->followcount = $dynamic->followcount+1;
            $dynamic->followdate = date('Y-m-d H:i:s');
            $dynamic->save();
            DB::commit();
            Cache::tags(['clientList','clientRefereeChart','HomeClientList'])->flush();
            return array_merge($data,["time"=> $dynamic->followdate]);
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
            foreach ( $res as $key=>$row )
            {
                //派单记录
                $dispatch[$key]['uuid'] = create_uuid();
                $dispatch[$key]['clientid'] = $row->clientid;
                $dispatch[$key]['type'] = 3;
                $dispatch[$key]['remark'] = '移交派单';
                $dispatch[$key]['adminid'] = $data['accept'];
                $dispatch[$key]['created_at'] = date('Y-m-d H:i:s');
                //移交记录
                $transfer[$key]['uuid'] = create_uuid();
                $transfer[$key]['clientid'] = $row->clientid;
                $transfer[$key]['beforeownadminid'] = $data['transfer'];
                $transfer[$key]['afterownadminid'] = $data['accept'];
                $transfer[$key]['remark'] = '客户移交';
                $transfer[$key]['created_at'] = date('Y-m-d H:i:s');
            }
            //写入派单记录
            ClientDispatch::insert($dispatch);
            //写入移交记录
            ClientTransfer::insert($transfer);
            //修改客户表
            ClientDynamic::whereIn('uuid',$data['uuid'])->update(['ownadminid'=>$data['accept']]);
            DB::commit();
            //清除缓存
            Cache::tags(['clientList','clientRefereeChart'])->flush();
            return 'success';
        }catch (Exception $e){
            DB::rollBack();
            responseData(\StatusCode::ERROR,'编辑失败');
        }
    }

    /****
     * 获取房源列表--推荐房源时候模糊搜索的下拉框内容
     */
    public function houseData()
    {
        try {
            //获取详情数据
            $row = House::select("id", "name", "addr")->get();
            if (empty($row->toArray())) {
                responseData(\StatusCode::EMPTY_ERROR, "无结果");
            }

        } catch (\ErrorException $e) {
            //记录日志
            Log::error('======ClientService-houseData:======' . $e->getMessage());
            //业务执行失败
            responseData(\StatusCode::CATCH_ERROR, "获取异常");
        } finally {
            //返回处理结果数据
            return $row;
        }
    }

}