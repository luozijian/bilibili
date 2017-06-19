@extends('layouts.app')

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
                            <source src="http://vjs.zencdn.net/v/oceans.mp4" type="video/mp4">
                            <source src="http://vjs.zencdn.net/v/oceans.webm" type="video/webm">
                            <source src="http://vjs.zencdn.net/v/oceans.ogv" type="video/ogg">
                            <p class="vjs-no-js">
                                To view this video please enable JavaScript, and consider upgrading to a web browser that
                                <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                            </p>
                        </video>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent


@endsection