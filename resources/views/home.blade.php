@extends('layouts.app')

@section('style')
    <style>
        .subtitle{
            position:absolute;
            background:grey;
            color: white;
            bottom:5em;
            width:92%;
        }
    </style>

@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('flash::message')
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">视频</div>
                    <div class="panel-body">

                        <video id="my-video" class="video-js" controls preload="auto" width="100%" height="100%"
                               poster="" data-setup="{}">
                            <source src="/video/Daniel Wu - on journey.mp4" type="video/mp4">
                            <p class="vjs-no-js">
                                想看该视频请不要禁用 JavaScript, 或者考虑升级浏览器，比如安装 HTML5 播放器
                                <a href="http://videojs.com/html5-video-support/" target="_blank">支持 HTML5</a>
                            </p>
                        </video>
                        <div class="subtitle">subtitle</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function(){

            console.log('hello');
            var $video = $('#my-video');
            var video = $video[0];
            var $subtitle = $('.subtitle');
            $video.bind('timeupdate',function(e){
                $subtitle.text(video.currentTime);
            });

        });
    </script>

@endsection