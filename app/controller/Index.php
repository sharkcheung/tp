<?php
namespace app\controller;

use app\BaseController;
use app\model\User;

class Index extends BaseController
{
    public function index()
    {
        return json(User::select());
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
