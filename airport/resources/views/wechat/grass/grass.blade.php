@extends('wechat.layout.frame',['title' => "种草"])
@section('content')
    <body class="p0m0">
    {{--背景图--}}

    {{--任务列表--}}
    <div class="grass-bg" style="background-image: url('{{asset("img/wechat/grass-bg.png")}}');margin-top: -10%;">
        @foreach($tasks as $task)
            <div class="label text-center task" style="margin-top: 5%;">
                <img src="{{asset('img/wechat/water.png')}}">
                @if($task->link != null)
                    <a href="{{url($task->link)}}">{{$task->message}}</a>
                @else
                    <a href="{{url('wechat/activity/show/task/'.$task->activity_id)}}">
                        {{$task->message}}
                    </a>
                @endif
                <div>+{{$task->prize_count}}{{$task->prize_name}}</div>
            </div>
        @endforeach

    </div>
    {{--任务列表end--}}

    {{--种草信息--}}
    <div class="ui feed personal" style="margin: 0 20px;">
        <div class="event">
            <div class="label">
                <img class="ui image" src="{{$user->user_wechats->headimgurl}}">
            </div>
            <div class="content">
                <div class="meta">
                    <span>等级</span>
                    <div class="ui tiny star rating test"
                         data-rating="{{$user->user_infos->level}}"
                         data-max-rating="5">
                    </div>
                    <a href="{{url('wechat/apply/person')}}">
                        {{$levels->where('id', $user->user_infos->level)->pluck('name')[0]}}
                    </a>
                </div>
                <div class="meta">
                    <span>经验</span>
                    <div id="exp" class="ui tiny green progress exp"
                         data-value="{{($user->user_infos->exp)/100}}"
                         data-total="50">
                        <div class="bar"></div>
                    </div>
                    <span> <span id="exp-count">{{($user->user_infos->exp)/100}}</span>00点</span>
                </div>
                <div class="meta">
                    <span>水量</span>
                    <div id="water" class="ui tiny blue progress exp"
                         data-value="{{($user->grass_attrs->water)/100}}"
                         data-total="20">
                        <div class="bar"></div>
                    </div>
                    <span><span id="water-count">{{($user->grass_attrs->water)/100}}</span>00滴</span>
                </div>
                <div class="meta">
                    <span>种草</span>
                    <span id="grass">收获<span>{{$count}}</span>棵
                          在种<span>{{$grasses->count()}}</span>棵
                          种子<span>{{$user->grass_attrs->seed}}</span>棵
                    </span>
                </div>
                <div class="meta">
                    <a id="showGrassRule" style="color: green;font-weight: bold;">查看活动规则</a>
                </div>
            </div>
        </div>
    </div>
    {{--种草信息end--}}



    {{--种草--}}
    <div class="segment">
        <div class="ui divider"></div>
        <div class="ui four cards apply-success p14">
            @foreach($grasses as $grass)
                <div class="card">
                    <div class="ui top attached tiny blue progress"
                         data-value="{{($grass->water)/100}}"
                         data-total="{{($grass->total)/100}}">
                        <div class="bar"></div>
                    </div>
                    <div class="center aligned content p4">
                        <div class="image p4">
                            <img src="{{asset('img/wechat/grass.png')}}" style="height: 50px;"/>
                        </div>

                    </div>
                    @if(date('Y-m-d') == date('Y-m-d',strtotime($grass->updated_at)))
                        <a class="ui bottom attached compact button p4">
                            已浇水
                        </a>
                    @else
                        <a
                                class="ui bottom attached compact blue button p4" data-value="{{$grass->id}}">
                            浇水
                        </a>
                    @endif
                </div>
            @endforeach
            <div class="card border-clear clear-shadow">
                @if($grasses->count() == 7)
                    <a>
                        <i class="ui large add icon"></i>
                    </a>
                @else
                    <a>
                        <i class="ui large add icon"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
    {{--种草end--}}


    {{--任务记录--}}
    @if($user_tasks !== null)
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
                    @if(\App\Models\ActivityQuestion::where('activity_id',$user_task->activity_id)->exists()
                    && !\App\Models\ResultQuestion::where('activity_id',$user_task->activity_id)->where('user_id',session('user_id'))->exists()
                    )
                        <a class="ui button" style="background-color: #f9f9f9;color:#009A44;"
                           href="{{url('wechat/activity/show/task_question/'.$user_task->activity_id)}}">
                            前去答题
                        </a>
                    @else

                        <a class="ui button" style="background-color: #f9f9f9;color:#009A44;"
                           href="{{url('wechat/activity/show/task/'.$user_task->activity_id)}}">
                            查看详情
                        </a>
                    @endif
                </div>
            </div>
        @endforeach

    </div>
    @endif

    {{--任务记录end--}}

    {{--备案--}}
    <div class="column">
        <div class="ui center aligned segment pb100">
            <a href="{{url('wechat/activity/show/task-list')}}" style="color:gray;">
                查看所有任务 >>
            </a>
        </div>
    </div>
    {{--备案end--}}


    @include("wechat.layout.grass-explain")

    <a href="{{url('wechat/apply')}}" id="user-submit" class="ui fluid green button absolute bottom" style="z-index: 100">返回首页</a>
    </body>
    <script>


        $('.rating').rating("disable");
        $('.progress').progress();

        $('.bottom.blue.button').one('click', water);

        function water() {
            if ($('#water').attr('data-value') == 0) {
                alert('亲，没水了！');
                return false;
            }
            $this = $(this);
            $.get("{{url('wechat/grass/water')}}" + "/" + $this.attr('data-value'), function (data) {
                if (data.state) {
                    alert(data.message);
                } else {
                    if (data[0].water == data[0].total) {
                        $('#grass').find('span:first')[0].innerHTML++;
                        $('#grass').find('span:eq(1)')[0].innerHTML--;
                        $this.parent().remove();
                    }
                    $('#water').progress('decrement');
                    $('#exp').progress('increment');
                    $('#water-count')[0].innerHTML--;
                    $('#exp-count')[0].innerHTML++;
                    $this.removeClass('blue').text('已浇水');
                    $this.parent().find('div:first').progress('increment');
                }
            }, 'json')
        }

        $('.large.add.icon').click(function () {
            $seed = $('#grass').find('span:eq(2)');
            if ($seed.text() == 0) {
                alert('亲，没种子了！');
                return false;
            } else if ($seed.prev().text() == 7) {
                alert('亲，最多可同时种7棵，请收获后再种！');
                return false;
            } else {
                $seed[0].innerHTML--;
                $seed.prev()[0].innerHTML++;
                $.get("{{url('wechat/grass/plant')}}", function (grass) {
                    //clone参数如果是true的话，将复制事件，这里千万别复制事件
                    var $copy = $('.four.cards>.card:first').clone();
                    $copy.find('div:first')
                        .attr('data-value', 0)
                        .attr('data-total', (grass.total) / 100);
                    $copy.find('a.bottom').text('浇水')
                        .addClass('blue')
                        .attr('data-value', grass.id);
                    $copy.find('div.bar').width(0);
                    $copy.find('a.bottom').one('click', water);
                    $('.four.cards>.card:last').before($copy);
                }, 'json');
            }
        });

        $(".cancel.button").click(function () {
            $status = $(this).parent().parent().find('.taskStatus');
            if ($status.hasClass("run")) {
                $.get($(this).attr('data-value'), function () {
                    alert("取消成功");
                    $status.text("状态：任务取消");
                })
            }
        });

        $('#showGrassRule').click(function () {
            $(".grass-explain.modal").modal('show');
        })

    </script>
@endsection