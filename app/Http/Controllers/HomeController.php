<?php

namespace App\Http\Controllers;

use App\Events\FirstLogin;
use App\Models\Barrage;
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

        $barrages = [];
        foreach (Barrage::all() as $key => $item){
            $barrages[$key]['img'] = $item->user->avatar;
            $barrages[$key]['info'] = $item->content;
            $barrages[$key]['href'] = 'http://www.yaseng.org';
            $barrages[$key]['speed'] = random_int(5,8);
            $barrages[$key]['color'] = '#fff';
            $barrages[$key]['old_ie_color'] = '#000000';
        }
        $barrages = json_encode($barrages);

        return view('home',compact('chinese_subtitles','english_subtitles','barrages'));
    }
}
