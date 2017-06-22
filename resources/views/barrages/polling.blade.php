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

        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="/js/jquery.barrager.js"></script>

    <script>
        setInterval("getBarrages()",5000);

        $(function(){

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
            $.ajax({
                type: "POST",
                url: "/api/barrages",
                data: "content="+content+"&user_id="+user_id,
                success: function(data){
                    if (data.success){
                        alert('发送成功');
                        $('[name="content"]').val('');
                        sendDanmu(data.data);
                    }
                },
                error : function() {
                    alert('字幕内容不能为空');
                },
            });
        }

        function sendDanmu(data) {
            const item={
                img:data.user_avatar, //图片
                info:data.content, //文字
                href:'http://www.yaseng.org', //链接
                close:true, //显示关闭按钮
                speed:8, //延迟,单位秒,默认8
                color:'#fff', //颜色,默认白色
                old_ie_color:'#000000', //ie低版兼容色,不能与网页背景相同,默认黑色
            };
            $('body').barrager(item);
        }

        function getBarrages(){
            $.ajax({
                type: "GET",
                url: "/api/barrages",
                success: function(data){
                    if (data.success){
                        let barrages = data.data;
                        for (let barrage of barrages){
                            $('body').barrager(barrage);
                        }
                    }
                },
                error : function() {
                    console.log('error');
                },
            });
        }
    </script>

@endsection