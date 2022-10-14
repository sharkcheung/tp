<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// 应用公共文件
function response($data=[], $code='', $msg='success')
{
    $res = [
        'code' => $code ? $code : config('code.success'),
        'msg' => $msg,
        'data' => $data
    ];
    return json($res);
}

/**
 * 随机字符
 * @param number $length 长度
 * @param string $type 类型
 * @param number $convert 转换大小写
 * @return string
 */
function random($length=6, $type='all', $convert=0)
{
    $config = array(
        'number'=>'1234567890',
        'letter'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'string'=>'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
        'all'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
        'allWithSymbol'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_'
    );
    if (!isset($config[$type])) {
        $type = 'all';
    }
    $string = $config[$type];
    $code = '';
    $strlen = strlen($string) -1;
    for ($i = 0; $i < $length; $i++) {
        $code .= $string[mt_rand(0, $strlen)];
    }
    if (!empty($convert)) {
        $code = ($convert > 0) ? strtoupper($code) : strtolower($code);
    }
    return $code;
}
