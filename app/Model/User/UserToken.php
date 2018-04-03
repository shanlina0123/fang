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
}