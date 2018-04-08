<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:26
 */

namespace App\Model\Client;
use Illuminate\Database\Eloquent\Model;
class ClientTransfer extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'client_transfer';
    public $timestamps = false;
}