<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:26
 */

namespace App\Model\Data;
use Illuminate\Database\Eloquent\Model;
class Select extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'role_function';
    public $timestamps = false;



    
}