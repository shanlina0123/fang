<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:26
 */

namespace App\Model\House;
use Illuminate\Database\Eloquent\Model;
class House extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'house';
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 关联下拉数据
     */
    public function houseToImage()
    {
        return $this->hasMany('App\Model\House\HouseImage','houseid','id');
    }
}