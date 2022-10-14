<?php

declare(strict_types=1);

namespace app\controller;

use think\Request;
use app\model\User as UserModel;

class Login
{
    /**
     * 登录
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function login(Request $request)
    {
        //
        $data = $request->param();
        $user = new UserModel();

        [$ret, $code, $msg] = $user->login($data);
        return response($ret, $code, $msg);
    }
    public function getCode($id = '')
    {
        if (!empty($id)) {
            $user = new UserModel();

            [$ret, $code, $msg] = $user->getCode($id);
            return response($ret, $code, $msg);
        } else {
            return response([], config('code.error'), '参数不正确');
        }
    }
}
