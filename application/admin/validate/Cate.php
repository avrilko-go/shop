<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2017/12/18
 * Time: 下午10:02
 */

namespace app\admin\validate;


use think\Validate;

class Cate extends Validate
{
    protected $rule=[
        'name'=>'require',
        'pid'=>'number'
    ];

    protected $message=[
        'name'=>'栏目名称必须填写',
        'pid'=>'上级栏目id必须为数字'
    ];
}