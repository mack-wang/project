@extends('wechat.layout.frame-home',["link"=>"https://www.juhetuangou.com/wechat/company"])
@section('content')
    <div class="ui one column grid columns feeds">

        {{--<div class="column pb0">--}}
            {{--<img class="ui image" src="{{$article->image}}" alt="">--}}
            {{--<div class="ui segment clear-shadow clear-border m0">--}}
                {{--<div class="ui header mb4">{{$article->title}}</div>--}}
                {{--<div>{{$article->brief}}</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="divider column"></div>--}}

        {{--活动内容--}}
        <div class="column" style="background-color: white;">
            {!! $article->content !!}
        </div>
        {{--活动内容end--}}
    </div>
@endsection