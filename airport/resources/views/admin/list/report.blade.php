@extends('admin.layout.frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">查看试用评价</div>
    <!--页面标题end-->
    <div class="ui container">
        <div class="ui comments">
            <div class="comment">
                <a class="avatar">
                    <img src="{{asset($report->user_wechats->headimgurl)}}">
                </a>
                <div class="content">
                    <a class="author" style="color:#3788b7;">{{$report->user_wechats->nickname}}</a>
                    <div class="ui heart rating" data-rating="{{$report->scores}}"
                         data-max-rating="5"></div>
                    <div class="text">
                        <p>{{$report->smoke}}</p>
                        <div class="ui segment clear-shadow border-clear p4"
                             style="background-color: #f7f7f7">
                            @foreach(str_getcsv($report->images) as $image)
                                <img class="ui inline tiny image p4 preview"
                                     src="{{asset('uploads/report/'.$image)}}"
                                     style="height: 100px;"
                                >
                            @endforeach
                        </div>
                    </div>
                    <div class="actions">
                        <a class="reply">{{\App\Helper::time_ago($report->created_at)}}</a>
                        @if(\App\Models\ReportGood::where('user_id',session('user_id'))->where('report_id',$report->id)->exists())
                            <a class="fr" style="color:#3788b7;opacity: 0.5;">
                                <i class="large yu-good icon"></i>
                                <span class="f14">{{$report->goods}}</span>
                            </a>
                        @else
                            <a class="fr" style="color:#3788b7;opacity: 0.5;">
                                <i class="large yu-good-o icon"></i>
                                <span class="f14">{{$report->goods}}</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ui basic modal" id="preview">
        <img src="" alt="" style="width: 100%">
    </div>
    </body>
@endsection