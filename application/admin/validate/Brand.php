<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2017/12/18
 * Time: 上午8:09
 */

namespace app\admin\validate;


use think\Validate;

class Brand extends Validate
{
    protected $rule=[
        'name'=>'require',
        'url'=>'url',
        'desc'=>'min:5',
        'status'=>'number'
    ];

    protected $message=[
        'name'=>'品牌名称必须填写',
        'url'=>'品牌地址必须符合url规则',
        'desc'=>'描述最少5个字符',
        'status'=>'状态必须为数字'
    ];
}