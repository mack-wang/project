@extends('wechat.layout.frame')
@section('content')
    <body>
    <div class="ui one column grid columns feeds">
        
        <div class="column pb0">
            <img class="ui image fullwidth" src="{{$article->image}}" alt="">
            <div class="ui segment clear-shadow clear-border m0">
                <div class="ui header mb4">{{$article->title}}</div>
                <div>{{$article->brief}}</div>
            </div>
        </div>

        <div class="divider column"></div>

        {{--活动内容--}}
        <div class="column" style="background-color: white;">
            <div style="padding-left: 14px;padding-bottom: 14px;">
                内容详情
            </div>
            <div class="ui divider m0"></div>
            {!! $article->content !!}
        </div>
        {{--活动内容end--}}
    </div>

    </body>
@endsection