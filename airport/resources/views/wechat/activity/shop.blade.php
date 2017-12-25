@extends('wechat.layout.frame')
@section('content')
    <body>
    <div class="ui one column grid columns feeds">
        {{--活动内容--}}
        <div class="column"  style="background-color: white;">
            {!! $activity->articles->content !!}
        </div>
        {{--活动内容end--}}
    </div>

    </body>
@endsection