<?php

namespace App\Http\Controllers;

use App\Models\Barrage;
use App\Models\Subtitle;
use App\Services\FirstLoginService;

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
        $service = new FirstLoginService();
        $service->firstLogin();

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
