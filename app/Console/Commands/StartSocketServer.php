<?php

namespace App\Console\Commands;

use App\Models\Barrage;
use Illuminate\Console\Command;
use Workerman\Lib\Timer;
use Workerman\Worker;
require_once base_path('vendor/workerman/workerman/Autoloader.php');

class StartSocketServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'workerman:httpserver {action} {--daemonize}';
    protected $signature = 'socket:server {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'start websocket server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $worker = new Worker("websocket://".env('SOCKET_HOST').":4000/websocket");


        // 启动4个进程对外提供服务
        $worker->count = 8;


        // 当收到客户端发来的数据后
        $worker->onMessage = function ($connection, $data) use ($worker) {

            // 打印json格式的数据
            $data = json_decode($data, true);
            // 返回json格式的数据
            if ($data['content'] === '') {
                $connection->send(json_encode(array('status' => false, 'msg' => '内容不能为空')));
            } else {
                Barrage::create($data);
                $all = Barrage::all();
                $barrages = [];
                foreach ($all as $key => $item) {
                    $barrages[$key]['img'] = $item->user->avatar;
                    $barrages[$key]['info'] = $item->content;
                    $barrages[$key]['href'] = 'http://www.yaseng.org';
                    $barrages[$key]['speed'] = random_int(5, 8);
                    $barrages[$key]['color'] = '#fff';
                    $barrages[$key]['old_ie_color'] = '#000000';
                }
                $barrages = json_encode(array('status' => true, 'msg' => '发送成功','data'=>$barrages));
                foreach ($worker->connections as $connection) {
                    $connection->send($barrages);
                }

            };

            // 运行worker

        };
            Worker::runAll();


    }
}


