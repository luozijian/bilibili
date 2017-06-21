<?php

namespace App\Listeners;

use App\Events\FirstLogin;
use App\Models\Subtitle;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImportSubtitle
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FirstLogin  $event
     * @return void
     */
    public function handle(FirstLogin $event)
    {
        $data = [];

        $subtitles = file_get_contents(asset($event->file));

        $subtitles = explode("\n",$subtitles);

        foreach ($subtitles as $subtitle){
            if (strlen($subtitle) <= 6){
                continue;
            }
            if (strpos($subtitle,'-->')){
                //时间
                $subtitle = str_replace(',','.',$subtitle);//去逗号
                $timestamp = explode('-->',$subtitle);

                $data['started_at'] = $this->dealString($timestamp[0]);

                $data['end_at'] = $this->dealString($timestamp[1]);
            }else{
                //歌词
                $data['content'] = rtrim($subtitle);
            }

            if ($data['started_at'] && $data['end_at'] && isset($data['content'])){
                $data['type'] = $event->type;
                Subtitle::create($data);
                $data = [];
            }
        }

    }

    protected function dealString($str){
        $str = rtrim($str);

        $str = explode(':',$str);

        foreach ($str as $key => $item){
            if (strpos($item,'00') || $item === '00'){
                unset($str[$key]);
            }
        }
        sort($str);//重构索引

        if(count($str) == 1){
            $str = $str[0];
        }else{

            $str[0] = str_replace('0','',$str[0]);//去0

            $str = $str[0] * 60 + $str[1];

        }

        return $str;
    }
}
