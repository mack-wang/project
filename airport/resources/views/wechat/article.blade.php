@extends('wechat.layout.frame')
@section('content')
    <body class="relative">
    <div class="ui one column grid columns feeds">
        {{--活动内容--}}
        <div class="column" style="background-color: white;">
            {!! $article->content !!}
        </div>
        {{--活动内容end--}}
    </div>

    <div class="ui sticky fixed  bottom" style="width: 100%;">
        <div class="ui huge circular label fr m28 backButton" onclick="history.go(-1)" style="opacity: 0.8;">
            <i class="ui white chevron left icon p0m0"></i>
        </div>
    </div>
    </body>
@endsection