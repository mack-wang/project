@extends('wechat.layout.frame',['title' => "评价报告"])
@section('content')
    <body>
    @if($applyReports->isEmpty())
            <div class="ui info message m28">您没有任何评价报告</div>
    @endif
    <div class="ui one column grid columns feeds">
        {{--申领记录--}}


        @foreach($applyReports as $report )
            <div class="column feeds">
                <div class="ui segment mt8 mb0">
                    <div class="ui feed ">
                        <div class="event">
                            <div class="label" style="padding-top: 2px;">
                                <i class="ui green newspaper icon"></i>
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <div>{{$report->activity_attrs->title}}</div>
                                </div>
                                <div class="meta">
                                    <div class="ui horizontal list">

                                        <div class="item f16">
                                            {{$report->created_at}}

                                        </div>
                                        <div class="item f16">
                                            @if($report->status === null)
                                                <div class="ui teal label">
                                                    进行中
                                                </div>
                                            @elseif($report->status === 0)
                                                <div class="ui red label">
                                                    未选中
                                                </div>
                                            @elseif($report->status === 1)
                                                <div class="ui green label">
                                                    申领成功
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($report->reports === null)
                    <a class="ui fluid compact attached bottom button"
                       href="{{url('wechat/report/write/'.$report->activity_id)}}" style="color:red">
                        <i class="ui edit icon"></i>未填写,前去填写
                    </a>
                @else
                    <a class="ui fluid compact attached bottom button"
                       href="{{url('wechat/activity/show/'.$report->activities->type.'/'.$report->activity_id.'/report')}}">
                        已填写，查看
                    </a>
                @endif
            </div>
        @endforeach

        {{--申领记录end--}}

    </div>
    <div class="ui segment border-clear clear-shadow text-center">
        {{$applyReports->links()}}
    </div>
    <a href="{{url('wechat/home')}}" id="user-submit" class="ui fluid green button absolute bottom">返回个人中心</a>
    </body>
@endsection