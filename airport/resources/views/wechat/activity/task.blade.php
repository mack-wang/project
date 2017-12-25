@extends('wechat.layout.frame-slide')
@section('content')
    <body>
    <div class="ui one column grid columns feeds">
        {{--头图--}}
        <div class="column">
              <img class="ui image fullwidth" src="{{asset('img/wechat/gettask.png')}}" alt="">
        </div>

        {{--导航说明--}}
        <div class="column">
            <div class="ui green inverted two item menu apply clear-shadow clear-radio">
                <div class="fitted item">
                    <div>
                        <div class="lighter text">领取条件</div>
                        @if($activity->activity_requires->exp != null)
                            <div>
                                经验{{$activity->activity_requires->exp}}点以上
                            </div>
                        @endif
                        @if($activity->activity_requires->level != null)
                            <div>
                                等级{{$activity->activity_requires->level}}星以上
                            </div>
                        @endif
                    </div>
                </div>
                <div class="right floated item">
                    <div>
                        <div class="lighter text">距结束仅剩</div>
                        <div>
                            @php
                                $time = \App\Helper::secondToDivide(strtotime($activity->end_at)-time());
                                echo '<span class="time">'.$time['day'].'</span> : ';
                                echo '<span class="time">'.$time['hour'].'</span> : ';
                                echo '<span class="time">'.$time['minute'].'</span> : ';
                                echo '<span class="time">'.$time['second'].'</span>';
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--导航说明end--}}

        {{--活动标题--}}
        <div class="column">
            <div class="ui segment">
                <div class="ui small lighter header p8">
                    <i class="red yu-fire icon p0m0"></i>
                    {{$activity->activity_tasks->title}}
                </div>
            </div>
        </div>
        {{--活动标题end--}}


        {{--活动内容--}}
        <div class="column" style="background-color: white;">
            <div class="mt8">
                {!! $activity->articles->content !!}
            </div>
        </div>
        {{--活动内容end--}}



        {{--警示提示--}}
        @include('wechat.layout.record')
        {{--警示提示end--}}
    </div>

    {{--底部菜单--}}
    <div class="ui bottom fixed three item apply menu">
        <div class="fitted item">
            <div>
                <div class="lighter text">任务奖励</div>
                <div class="strong text">
                    +{{$activity->activity_tasks->prize_count}}{{$activity->activity_tasks->prize_name}}</div>
            </div>
        </div>
        <div class="fitted item">
            <div>
                <div class="lighter text">已领取人数</div>
                <div class="strong text">{{$activity->result_tasks->count()}}人</div>
            </div>
        </div>
        @php
            if($result_task === null && strtotime($activity->end_at) > time()){
                echo '<div id="apply" class="taskStatus apply item applied">领取任务</div>';
            }elseif($result_task->status === null){
                echo '<div id="apply" class="taskStatus run item applied">已领取任务</div>';
            }elseif($result_task->status === 1){
                echo '<div id="apply" class="taskStatus success item applied">任务完成</div>';
            }elseif($result_task->status === 0){
                echo '<div id="apply" class="taskStatus cancel item applied">任务取消</div>';
            }elseif(strtotime($activity->end_at) < time()){
                echo '<div id="apply" class="taskStatus timeout item applied">任务过期</div>';
            }
        @endphp
    </div>
    {{--底部菜单end--}}


    <script>
        $('.taskStatus.apply').one('click',function () {
            $.get('{{url("wechat/activity/requires")."/".$activity->id}}', function (auth) {
                if (auth == "exp_error") {
                    alert("你的经验未达到{{$activity->activity_requires->exp}}点以上,不能报名");
                    return false;
                }

                if (auth == "level_error") {
                    alert("你的等级未达到{{$activity->activity_requires->level}}星以上,不能报名");
                    return false;
                }

                if (auth == "success") {
                    $.get('{{url("wechat/task/get/".$activity->id)}}', function (data) {
                        if(data.className == "error"){
                            alert(data.message);
                            return false;
                        }else if(data.className == "run"){
                            alert(data.message);
                        }
                        $('.taskStatus.apply').text(data.message).removeClass('apply').addClass(data.className);
                    }, 'json');
                }
            })
        })


    </script>

    </body>
@endsection