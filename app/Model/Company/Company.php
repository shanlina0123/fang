<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:26
 */

namespace App\Model\Company;
use Illuminate\Database\Eloquent\Model;
class Company extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'company';
    public $timestamps = true;
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];
}