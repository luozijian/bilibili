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
                $timestamp = explode('-->',$subtitle);
                $data['started_at'] = rtrim($timestamp[0]);
                $data['end_at'] = rtrim($timestamp[1]);
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
}
