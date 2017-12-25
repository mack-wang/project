@extends('wechat.layout.frame')
@section('content')
    <body class="p0m0">


    @if($hasTasks)
        {{--任务记录--}}
        <div class="ui one column grid columns feeds">
            @foreach($user_tasks as $user_task)
                <div class="column flow">
                    <div class="ui attached top segment mt8" style="border-color:white;">
                        <div class="ui feed m0">
                            <div class="event">
                                <div class="label">
                                    <i class="ui green browser icon"></i>
                                </div>
                                <div class="content m0">
                                    <div class="meta">
                                        {{$user_task->activity_tasks->message}}
                                    </div>
                                    <div class="meta">
                                        {{$user_task->created_at}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="ui list" style="margin: 10px 35px;">
                                <div class="item">任务：{{$user_task->activity_tasks->title}}</div>
                                <div class="item">
                                    奖励：+{{$user_task->activity_tasks->prize_count.$user_task->activity_tasks->prize_name}}</div>

                                @php
                                    if($user_task->status === 1){
                                        echo '<div class="taskStatus success item">状态：任务完成</div>';
                                    }elseif($user_task->status === 0){
                                        echo '<div class="taskStatus cancel item">状态：任务取消</div>';
                                    }elseif(strtotime($user_task->activities->end_at) < time()){
                                        echo '<div class="taskStatus timeout item">状态：任务过期</div>';
                                    }else{
                                        echo '<div class="taskStatus run item">状态：任务进行中</div>';
                                    }
                                @endphp

                                <div class="item">截止：{{$user_task->activities->end_at}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="ui fluid compact attached bottom buttons">
                        <a class="ui cancel button" style="background-color: #f9f9f9;color:#009A44;"
                           data-value="{{url('wechat/task/cancel/'.$user_task->activity_id)}}">
                            取消任务
                        </a>
                        <a class="ui button" style="background-color: #f9f9f9;color:#009A44;"
                           href="{{url('wechat/activity/show/task/'.$user_task->activity_id)}}">
                            查看详情
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    @else
        <div class="ui segment clear-shadow border-clear">
            <div class="ui message info m28">您暂时还没有领取任务！</div>
        </div>
    @endif
    {{--任务记录end--}}

    {{--备案--}}
        <div class="ui center aligned container m28">
            {{ $user_tasks->links() }}
        </div>
    {{--备案end--}}
    <div style="width: 100%;height: 100px;"></div>
    <a href="{{url('wechat/grass/index')}}" id="user-submit" class="ui fluid green button absolute bottom" style="z-index: 1000">返回种草</a>
    </body>
    <script>
        $(".cancel.button").click(function () {
            $status = $(this).parent().parent().find('.taskStatus');
            if ($status.hasClass("run")) {
                $.get($(this).attr('data-value'), function () {
                    alert("取消成功");
                    $status.text("状态：任务取消");
                })
            }
        })
    </script>
@endsection