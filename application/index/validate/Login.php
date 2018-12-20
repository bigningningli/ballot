<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/26 0026
 * Time: 下午 1:50
 */

namespace app\index\validate;
use think\Validate;
class Login extends Validate
{
    protected $rule=[
        'username'=>'require|max:16',
        'p'=>'require|max:25'
    ];
    protected $message=[
        'username.require'=>'用户名必须！',
        'username.max'=>'用户名最大长度为16',
        'p.require'=>'密码必须',
        'p.max'=>'密码最大长度为25'
    ];
}