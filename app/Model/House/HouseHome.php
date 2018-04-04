<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:26
 */

namespace App\Model\House;
use Illuminate\Database\Eloquent\Model;
class HouseHome extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'house_home';
    public $timestamps = false;

}