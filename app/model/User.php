<?php

namespace app\model;

use think\Model;
use thans\jwt\facade\JWTAuth;
use think\facade\Cache;

class User extends Model
{
    public function createUser($data)
    {
        $salt = random(16);
        $data['pass_salt'] = $salt;
        $user = new User();
        try {
            $info = $user->where('username', $data['username'])->find();
            if ($info) {
                return [[], config('code.error'), '用户已存在！'];
            }
            $ret = $user->insertGetId($data);
            $data['id'] = (int)$ret;
            if ($ret) {
                return [$data, config('code.success'), '用户创建成功！'];
            } else {
                return [[], config('code.error'), '用户创建失败！'];
            }
        } catch(\Exception $e) {
            // 验证失败 输出错误信息
            var_dump($e);
            return [[], config('code.error'), '用户创建失败！'];
        }
    }
    public function updateUser($data, $id)
    {
        $user = new User();
        unset($data['username'], $data['pass_salt']);
        try {
            $info = $user->where('id', $id)->find();
            if (!$info) {
                return [[], config('code.error'), '用户不存在！'];
            }
            $ret = $info->save($data);
            if ($ret) {
                return [[], config('code.success'), '用户修改成功！'];
            } else {
                return [[], config('code.error'), '用户修改失败！'];
            }
        } catch(\Exception $e) {
            // 验证失败 输出错误信息
            return [[], config('code.error'), '用户修改失败！'];
        }
    }
    public function getUserInfo($id)
    {
        $user = new User();
        $info = $user->where('id', $id)->find();
        if (!$info) {
            return [[], config('code.error'), '用户不存在！'];
        }
        return [$info, config('code.success'), ''];
    }
    public function login($data)
    {
        $user = new User();
        $info = $user->where('username', $data['username'])->find();
        if (!$info) {
            return [[], config('code.error'), '用户不存在！'];
        }
        $token = JWTAuth::builder(['uid' => $info['id']]);
        return [[
            'token' => 'Bearer ' . $token
        ], config('code.success'), '登录成功！'];
    }
    public function getCode($id)
    {
        $code = random(20, 'allWithSymbol');
        Cache::set($id, $code, 60);
        return [[
            'code' => $code
        ], config('code.success'), ''];
    }
}
