@extends('layouts.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="/css/barrager.css">
    <style>
        .subtitle{
            position:absolute;
            background:grey;
            color: white;
            width:95%;
            bottom:5em;
        }
    </style>

@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('flash::message')
            <div class="col-md-12">
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
                        <div class="subtitle">
                            subtitle
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        弹幕发送区
                    </div>
                    <div class="panel-body">
                        @if(Auth::check())
                            <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                                {!! Form::textarea('content', null, ['class' => 'form-control','required']) !!}
                                @if ($errors->has('content'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button class="btn btn-success pull-right" type="submit" onclick="store()">发布弹幕</button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-success btn-block">登录发布弹幕</a>
                        @endif
                    </div>
                </div>
            </div>
            <button onclick="initSocket()">test</button>
            <div id="log"></div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="/js/jquery.barrager.js"></script>

    <script>

        $(function(){
            initSocket();

            let chinese_subtitles = '{!! $chinese_subtitles !!}';
            let english_subtitles = '{!! $english_subtitles !!}';

            chinese_subtitles = JSON.parse(chinese_subtitles);
            english_subtitles = JSON.parse(english_subtitles);

            const $video = $('#my-video');

            const video = $video[0];

            const $subtitle = $('.subtitle');

            $video.bind('timeupdate',function(){

                let chinese_content = findChineseContent(video.currentTime);
                let english_content = findEnglishContent(video.currentTime);
                $subtitle.html( '<p style="text-align: center">'+ chinese_content + '<br>' + english_content +'</p>' );

            });

            function findChineseContent(currentTime) {
                for (let subtitle of chinese_subtitles){
                    if(currentTime <= subtitle.end_at && currentTime >= subtitle.started_at){
                        return subtitle.content;
                    }
                }
                return currentTime;
            }

            function findEnglishContent(currentTime) {
                for (let subtitle of english_subtitles){
                    if(currentTime <= subtitle.end_at && currentTime >= subtitle.started_at){
                        return subtitle.content;
                    }
                }
                return '';
            }


        });

        function store(){
            let content = $('[name="content"]').val();
            let user_id = '{{ Auth::id() }}';
            let data = {
                content : content,
                user_id : user_id,
            };
            data = JSON.stringify(data);
            socket.send(data);

        }



        function log(msg) {
            $("log").innerHTML+="<br>"+msg;
        }

        function initSocket() {
            //初始化socket
            let host = "ws://"+ '{!! env('SOCKET_HOST') !!}' +":4000";
            try{
                socket = new WebSocket(host);
                log('WebSocket - status '+socket.readyState);
                socket.onopen    = function(msg){ log("Welcome - status "+this.readyState); };
                socket.onmessage = function(result){

                    let res = JSON.parse(result.data);
                    alert(res.msg);
                    console.log(res);

                    if (res.status){
                        $('[name="content"]').val('');
                        for (let barrage of res.data){
                            $('body').barrager(barrage);
                        }
                    }

                };
                socket.onclose   = function(msg){ log("Disconnected - status "+this.readyState); };
            } catch(ex) {
                log(ex);
            }
        }



    </script>
@endsection