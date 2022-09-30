<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'username'  => 'require|max:20',
        'password'   => 'require|max:20|min:8',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'username.require' => '账号不能为空',
        'username.max'     => '账号最多不能超过20个字符',
        'password.require' => '密码不能为空',
        'password.min'     => '密码最少8个字符',
        'password.max'     => '密码最多不能超过20个字符',
    ];

    protected $scene = [
        'edit'  =>  ['password'],
    ];  
}
