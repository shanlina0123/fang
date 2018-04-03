<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:26
 */

namespace App\Model\Data;
use Illuminate\Database\Eloquent\Model;
class SelectCateDefault extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_select_cate_default';
    public $timestamps = false;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 关联下拉数据
     */
    public function cateDefaultToSelect()
    {
        return $this->hasMany('App\Model\Data\SelectDefault','cateid','id');
    }
}