<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:52
 */

namespace App\Service\Admin;
use App\Model\Data\Functions;
use App\Model\Roles\Role;
use App\Model\Roles\RoleFunction;
use App\Model\User\AdminToken;
use App\Service\AdminBase;
use App\Model\User\AdminUser;
use Illuminate\Support\Facades\Log;

class LoginService extends AdminBase
{

    /**
     * @return int
     * 错误信息
     */
    public function errorsMessages()
    {
       $msg = [
           'name.required'=>'用户名不能为空',
           'password.required'=>'密码不能为空'
       ];
       return $msg;
    }

    public function checkUser( $data )
    {
        if( is_numeric($data['name']) )
        {
            $where['mobile'] = $data['name'];
        }else
        {
            $where['name'] = $data['name'];
        }
        $where['password'] = optimizedSaltPwd("admin",base64_decode($data['password']));
        $user = AdminUser::where( $where )->select('id','uuid','name',"nickname", 'isadmin',"roleid",'mobile','status','wechatopenid')->first();

        if( $user == false )
        {
            responseData(\StatusCode::LOGIN_FAILURE,'用户名密码错误');
        }
        if( $user->status == 0 )
        {
            responseData(\StatusCode::USER_LOCKING,'用户锁定');
        }

        $tWhere['userid'] = $user->id;
        $uToken = AdminToken::where( $tWhere )->first();
        if( $uToken )
        {
            $uToken->token = str_random(60);
            $uToken->expiration = time()+604800;//7天
            $uToken->save();
        }else
        {
            $uToken = new AdminToken();
            $uToken->uuid = create_uuid();
            $uToken->token = str_random(60);
            $uToken->expiration = time()+604800;//7天
            $uToken->userid = $user->id;
            $uToken->save();
        }
        $user->token = $uToken->token;
        $user->expiration = $uToken->expiration;

        $adminRole=$this->getLoginMenue($user->isadmin,$user->roleid);
        $user->roleFunids=$adminRole["roleFunids"];
        $user->menuList=$adminRole["menuList"];
        return $user;
    }

    /**
     * @param $uuid
     * @return string
     * 绑openid
     */
    public function checkOpenid( $uuid )
    {
        $res = AdminUser::where('uuid',$uuid)->value('wechatopenid');
        if( $res )
        {
            return $res;
        }else
        {
            responseData(\StatusCode::ERROR,'未绑定');
        }
    }


    /**
     * @param $data
     * @return mixed
     * 忘记密码扫码检测状态
     */
    public function checkWechatbackStatus( $data )
    {
        $res = AdminUser::where(['uuid'=>$data['uuid'],'wechatbackstatus'=>1])->select('id','name','uuid','wechatopenid','wechatbackstatus')->first();
        if( $res )
        {
            $data = $res;
            $res->wechatbackstatus = 0;
            $res->save();
            return $data;
        }else
        {
            responseData(\StatusCode::ERROR,'未扫码');
        }
    }


    /**
     * @param $data
     * @return string
     * 修改密码
     */
    public function modifyPass( $data )
    {
        $where['wechatopenid'] = $data['wechatopenid'];
        $where['uuid'] = $data['uuid'];
        $res = AdminUser::where( $where )->first();
        if( $res )
        {
            $res->password = optimizedSaltPwd("admin",base64_decode($data['password']));
            if( $res->save() )
            {
                return 'success';
            }else
            {
                responseData(\StatusCode::ERROR,'修改失败');
            }
        }else
        {
            responseData(\StatusCode::ERROR,'未查询到');
        }
    }


    /***
     * 获取登录后已有的权限菜单
     * @param $admin
     */
    protected  function  getLoginMenue($isadmin,$roleid)
    {
        //非管理员已有的功能id
        if($isadmin==0)
        {
            //具备的权限功能
            $roleFuncObj = RoleFunction::where(["roleid" => $roleid, "status" => 1])->select("functionid")->get();
            $admin["roleFunids"] = array_flatten($roleFuncObj->toArray());
            //菜单列表
            $admin["menuList"]=$this->getMnueTmp($admin["roleFunids"]);
        }else{
            $admin["roleFunids"]=[];
            $admin["menuList"]=[];
        }
        return $admin;
    }

    /****
     * 权限ids
     * @param $roleFunids
     * @return array
     */
    protected  function getMnueTmp($roleFunids)
    {
        //获取菜单列表
        $queryModel= Functions::select("id", "menuname","menuicon", "pid", "level","url")
            ->where("ismenu",1)
            ->where("level","<=",2)
            ->where("status",1)
            ->orderBy('sort', 'asc');
        //检查权限
        if(count($roleFunids)>0)
        {
            $queryModel->whereIn("id",$roleFunids);
        }

        $objList =$queryModel->get();

        //结果检测
        if (empty($objList)) {
            return [];
        }
        //生成tree数组
        return list_to_tree($objList->toArray(),"id","pid", '_child',0);
    }
}