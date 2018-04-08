<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:26
 */

namespace App\Model\Client;
use Illuminate\Database\Eloquent\Model;
class ClientDispatch extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'client_dispatch';
    public $timestamps = false;
}