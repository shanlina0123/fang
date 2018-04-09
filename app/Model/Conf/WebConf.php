<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:26
 */

namespace App\Model\Conf;
use Illuminate\Database\Eloquent\Model;
class WebConf extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'web_conf';
    public $timestamps = false;
}