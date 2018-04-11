<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:26
 */

namespace App\Model\Data;
use Illuminate\Database\Eloquent\Model;
class Province extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_province';
    public $timestamps = false;
    protected $hidden = [
        'created_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 关联城市
     */
    public function ProvinceToCity()
    {
        return $this->hasMany('App\Model\Data\City','provinceid','id');
    }

}