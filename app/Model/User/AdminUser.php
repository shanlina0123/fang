<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:26
 */

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;
class AdminUser extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'admin';
    public $timestamps = false;

    protected $hidden = [
        'password','created_at','updated_at'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联角色
     */
    public function dynamicToRole()
    {
        return $this->belongsTo('App\Model\Roles\Role','roleid','id');
    }
}