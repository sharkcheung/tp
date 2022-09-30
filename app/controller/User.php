<?php

declare(strict_types=1);

namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\User as UserModel;
use app\validate\User as UserValidate;
use think\exception\ValidateException;

class User extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $user = UserModel::select();
        return response($user);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $request->param();
        try {
            $data = $request->only(['username', 'password', 'nickname', 'sex']);
            validate(UserValidate::class)->check($data);
            $user = new UserModel();
            [$ret, $code, $msg] = $user->createUser($data);
            return response($ret, $code, $msg);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            return response([], config('code.error'), $e->getError());
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        $user = new UserModel();
        [$ret, $code, $msg] = $user->getUserInfo($id);
        return response($ret, $code, $msg);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->param();
        try {
            $data = $request->only(['sex','password', 'nickname']);
            validate(UserValidate::class)->scene('edit')->check($data);
            $user = new UserModel();
            [$ret, $code, $msg] = $user->updateUser($data, $id);
            return response($ret, $code, $msg);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            return response([], config('code.error'), $e->getError());
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
        $user = UserModel::destroy($id);
        return response([], config('code.success'), '删除成功');
    }
}
