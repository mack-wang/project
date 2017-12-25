@extends('admin.layout.swiper-frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">活动详情</div>
    <!--页面标题end-->
    <div class="ui container pb100">
        <div class="ui two column  grid">
            <div class="ten wide computer only column">
                <table class="ui selectable celled table">
                    <thead>
                    <tr>
                        <th class="eight wide">项目</th>
                        <th class="eight wide">值</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="warning">任务奖励</td>
                        <td>+{{$activity->activity_tasks->prize_count}}{{$activity->activity_tasks->prize_name}}</td>
                    </tr>
                    <tr>
                        <td class="warning">务报名人数</td>
                        <td>{{$results['userCount'] or 0}}</td>
                    </tr>
                    <tr>
                        <td class="warning">完成任务人数</td>
                        <td>{{$results['winnerCount'] or 0}}</td>
                    </tr>
                    </tbody>
                </table>

                <div class="ui action input">


                    <!--文章选择-->
                    <div class="ui search article yu-hidden mr-1">
                        <div class="ui  icon input">
                            <input id="articleTitle" class="prompt clear-radio" type="text" placeholder="选择文章">
                            <i class="search icon"></i>
                        </div>
                        <div class="results"></div>
                    </div>

                    <!--验证题目选择-->
                    <div class="ui search question yu-hidden mr-1">
                        <div class="ui  icon input">
                            <input class="prompt clear-radio" type="text" placeholder="验证题目">
                            <i class="search icon"></i>
                        </div>
                        <div class="results"></div>
                    </div>


                    <input id="editInput" type="text" placeholder="请输入修改内容" data-value="{{$activity->id}}" data-type="{{$activity->type}}">

                    <div class="ui selection dropdown applyDetail">
                        <i class="dropdown icon"></i>
                        <div class="default text">请选择修改项</div>
                        <div class="menu">
                            <div class="item" data-value="title" data-content="{{$activity->activity_tasks->title}}">
                                标题
                            </div>
                            <div class="item" data-value="message" data-content="{{$activity->activity_tasks->message}}">
                                小标题
                            </div>
                            <div class="item" data-value="exp" data-content="{{$activity->activity_requires->exp}}">
                                经验条件
                            </div>
                            <div class="item" data-value="level" data-content="{{$activity->activity_requires->level}}">
                                等级条件
                            </div>
                            <div class="item" data-value="type" data-content="{{$activity->activity_tasks->type}}">
                                任务类型
                            </div>
                            <div class="item" data-value="top" data-content="{{$activity->activity_tasks->top}}">
                                置顶
                            </div>
                            <div class="item" data-value="start_at" data-content="{{$activity->start_at}}">
                                开始时间
                            </div>
                            <div class="item" data-value="end_at" data-content="{{$activity->end_at}}">
                                结束时间
                            </div>
                            <div class="item" data-value="prize_count"
                                 data-content="{{$activity->activity_tasks->prize_count}}">
                                奖励数量
                            </div>
                            <div class="item" data-value="prize_type"
                                 data-content="{{$activity->activity_tasks->prize_type}}">
                                奖品类型
                            </div>
                            <div class="item" data-value="prize_name"
                                 data-content="{{$activity->activity_tasks->prize_name}}">
                                奖品名称
                            </div>
                            <div class="item" data-value="article_id" data-content="{{$activity->article_id}}">
                                文章选择
                            </div>
                            <div class="item" data-value="question_id" data-content="{{$question->question_id or ""}}">
                                题目选择
                            </div>
                        </div>
                    </div>
                    <div id="applyDetailSubmit" class="ui button">修改</div>
                </div>

                <!--活动轮播图模块-->
                <div class="ui segment clear-shadow yu-hidden">
                    <div id="imageBox" class="ui two special cards headimg_box" data-limit="4">
                    </div>
                    <div class="ui hidden divider"></div>
                    <div id="imageAdd" class="ui big basic icon button">
                        <i class="ui icon add"></i>
                    </div>
                    {{--隐藏ueditor的视图，仅用于调用和实例化--}}
                    <div style="display: none;">
                        <script id="uploadImage" type="text/plain"></script>
                    </div>
                </div>

                <!--测评奖品描述-->
                <div id="describe" class="ui bottom  attached segment yu-hidden">
                    <a id="describe_add" class="fr"><i class="yu-add"></i>添加</a>
                    <div class="tow fields">
                        <div class="field">
                            <input type="text" class="describe_title" placeholder="标题">
                        </div>
                        <div class="field">
                            <input type="text" class="describe_content" placeholder="内容">
                        </div>
                    </div>
                </div>

            </div>


            <div class="six wide computer only column p0" style="height: 700px;overflow: auto;">
                {{--头图--}}
                <div class="column">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img class="ui image slide" src="{{asset('img/wechat/gettask.png')}}" alt="">
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
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
                                @if(strtotime($activity->end_at)>time())
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
                                @else
                                    <div class="lighter text">任务已经结束</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{--导航说明end--}}

                {{--活动标题--}}
                <div class="column">
                    <div class="ui segment clear-shadow border-clear">
                        <div class="ui small lighter header p8">
                            <i class="red yu-fire icon p0m0"></i>
                            {{$activity->activity_tasks->title}}
                        </div>
                    </div>
                </div>
                {{--活动标题end--}}

                {{--活动内容--}}
                <div class="column" style="background-color: white;">
                    <div>
                        {!! $activity->articles->content !!}
                    </div>
                </div>
                {{--活动内容end--}}

                @if($question !== null)
                    <div class="column">
                        <div class="ui fluid card">
                            <div class="ui header p10">
                                验证问题
                            </div>
                            @if($question->questions->image_path != null)
                                <img class="ui image" src="{{asset($question->questions->image_path)}}" alt="">
                            @endif
                            <div class="content">
                                <form class="ui form"
                                      @if($question->questions->type == "photo") enctype="multipart/form-data" @endif >
                                    <div class="grouped fields">
                                        <label class="f16">{{$question->questions->question}}</label>
                                        @if($question->questions->type == "radio")
                                            @foreach(str_getcsv($question->questions->options) as $option)
                                                <div class="field">
                                                    <div class="ui question radio checkbox">
                                                        <input type="radio" value="{{$loop->iteration}}">
                                                        <label>{{$option}}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @elseif($question->questions->type == "select")
                                            @foreach(str_getcsv($question->questions->options) as $option)
                                                <div class="field">
                                                    <div class="ui question checkbox">
                                                        <input type="checkbox" value="{{$loop->iteration}}">
                                                        <label>{{$option}}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @elseif($question->questions->type == "photo")
                                            <div class="field">
                                                <input type="file" name="photo" placeholder="选取照片">
                                            </div>
                                        @elseif($question->questions->type == "input")
                                            <div class="field">
                                                <input type="text" name="input" placeholder="请输入">
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            @if($question->questions->selected !==null)
                                <div class="meta p10">
                                    答案：第{{$question->questions->selected}}项为正确答案
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
    </body>
@endsection