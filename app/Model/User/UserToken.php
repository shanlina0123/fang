<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:26
 */

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;
class UserToken extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'user_token';
    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联用户表
     */
    public function tokenToAdminUser()
    {
        return $this->belongsTo('App\Model\User\AdminUser','userid','id');
    }
}