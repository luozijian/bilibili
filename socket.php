<?php

use Workerman\Worker;
require_once 'vendor/workerman/workerman/Autoloader.php';

$ws_worker = new Worker("websocket://192.168.10.10:4000");

// 启动4个进程对外提供服务
$ws_worker->count = 4;

// 当收到客户端发来的数据后
$ws_worker->onMessage = function($connection, $data)
{
// 打印json格式的数据
    var_export(json_decode($data));
// 返回json格式的数据
    $connection->send(json_encode(array('name'=>'lilei','age'=>18)));
};

// 运行worker
Worker::runAll();