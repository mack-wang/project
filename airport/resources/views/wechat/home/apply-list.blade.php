@extends('wechat.layout.frame',['title' => "申请记录"])
@section('content')
    <body>
    @if($applies->isEmpty())
        <div class="ui info message m28">您没有任何申请记录</div>
    @endif
    <div class="ui one column grid columns feeds">
        {{--申领记录--}}
        @foreach($applies as $apply )
            <div class="column feeds">
                <div class="ui segment mt8 mb0">
                    <div class="ui feed ">
                        <div class="event">
                            <div class="label" style="padding-top: 2px;">
                                <i class="ui green newspaper icon"></i>
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <div>{{$apply->activity_attrs->title}}</div>
                                </div>
                                <div class="meta">
                                    <div class="ui horizontal list">

                                        <div class="item f16">
                                            {{$apply->created_at}}

                                        </div>
                                        <div class="item f16">
                                            @if($apply->status === null)
                                                <div class="ui teal label">
                                                    进行中
                                                </div>
                                            @elseif($apply->status === 0)
                                                <div class="ui red label">
                                                    未选中
                                                </div>
                                            @elseif($apply->status === 1)
                                                <div class="ui green label">
                                                    申请成功
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(strtotime($apply->activities->end_at) > time())
                    <a href="{{url('wechat/activity/show').'/'.$apply->activities->type.'/'.$apply->activity_id}}"
                       class="ui fluid compact attached bottom button">查看活动详情</a>
                @else
                    <a href="{{url('wechat/activity/show/'.$apply->activities->type.'/'.$apply->activity_id.'/report')}}"
                       class="ui fluid compact attached bottom button">查看评价报告</a>
                @endif
            </div>
        @endforeach

        {{--申领记录end--}}

    </div>
    <div class="ui segment border-clear clear-shadow text-center">
        {{$applies->links()}}
    </div>
    <a href="{{url('wechat/home')}}" id="user-submit" class="ui fluid green button absolute bottom">返回首页</a>
    </body>
@endsection