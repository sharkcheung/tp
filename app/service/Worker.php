<?php

declare(strict_types=1);

namespace app\service;

use think\worker\Server;

class Worker extends Server
{
    protected $socket = 'http://0.0.0.0:2346';

    public function onMessage($connection, $data)
    {
        $connection->send(json_encode($data));
    }
}