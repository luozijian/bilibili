<?php

namespace App\Http\Controllers;

use App\Events\FirstLogin;
use App\Models\Subtitle;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //创建另一个数据库
        \DB::statement('CREATE DATABASE if not exists exam_07');

        \DB::connection('mysql_center')->statement("CREATE TABLE IF NOT EXISTS users (id int(10),name varchar(255),email varchar(255),password varchar(255))");

        $user = \DB::connection('mysql_center')->select('select * from users');

        if (!$user){
            //第一次访问
            \DB::connection('mysql_center')->insert('insert into users (id, name,email,password) values (?, ?, ?, ?)',[1,'admin','564774252@qq.com','admin']);
            event(new FirstLogin('video/Daniel Wu - on journey-zh-en.srt','chinese'));
            event(new FirstLogin('video/Daniel Wu - on journey.srt','english'));
        }

        $chinese_subtitles = json_encode(Subtitle::where('type','chinese')->get());
        $english_subtitles = addslashes(json_encode(Subtitle::where('type','english')->get()));//转义

        return view('home',compact('chinese_subtitles','english_subtitles'));
    }
}
