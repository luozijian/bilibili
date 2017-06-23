<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
    protected $signature = 'socket:start';

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
//        new App\Services\WebSocketService('192.168.10.10',4000);
    }

}
