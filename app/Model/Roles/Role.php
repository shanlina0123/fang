<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:26
 */

namespace App\Model\Roles;
use Illuminate\Database\Eloquent\Model;
class Role extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'role';
    public $timestamps = false;




}