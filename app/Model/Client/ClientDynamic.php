<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:26
 */

namespace App\Model\Client;
use Illuminate\Database\Eloquent\Model;
class ClientDynamic extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'client_dynamic';
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联用户表
     */
    public function dynamicToClient()
    {
        return $this->belongsTo('App\Model\Client\Client','clientid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联公司
     */
    public function dynamicToCompany()
    {
        return $this->belongsTo('App\Model\Company\Company','companyid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联前端用户
     */
    public function dynamicToUser()
    {
        return $this->belongsTo('App\Model\User\Users','refereeuserid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联跟进人
     */
    public function dynamicToAdminUser()
    {
        return $this->belongsTo('App\Model\User\AdminUser','followadminid','id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联归属者
     */
    public function dynamicToAdminOwn()
    {
        return $this->belongsTo('App\Model\User\AdminUser','ownadminid','id');
    }
}