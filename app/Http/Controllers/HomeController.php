<?php

namespace App\Http\Controllers;

use App\Models\Subtitle;
use Illuminate\Http\Request;

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
        $data = [];

        $subtitles = file_get_contents(asset('/video/Daniel Wu - on journey-zh-en.srt'));

        $subtitles = explode("\n",$subtitles);

        foreach ($subtitles as $subtitle){
            if (strlen($subtitle) <= 6){
                continue;
            }
            if (strpos($subtitle,'-->')){
                //时间
                $timestamp = explode('-->',$subtitle);
                $data['started_at'] = rtrim($timestamp[0]);
                $data['end_at'] = rtrim($timestamp[1]);
            }else{
                //歌词
                $data['content'] = rtrim($subtitle);
            }

            if ($data['started_at'] && $data['end_at'] && isset($data['content'])){
                Subtitle::create($data);
                $data = [];
            }
        }
        return view('home');
    }
}
