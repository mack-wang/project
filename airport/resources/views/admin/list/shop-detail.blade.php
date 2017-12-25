@extends('admin.layout.swiper-frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">活动详情</div>
    <!--页面标题end-->
    <div class="ui container pb100">
        <div class="ui two column  grid">

            <div class="ten wide column">
                <div class="ui action input">

                    <!--文章选择-->
                    <div class="ui search article yu-hidden mr-1">
                        <div class="ui  icon input">
                            <input id="articleTitle" class="prompt clear-radio" type="text" placeholder="选择文章">
                            <i class="search icon"></i>
                        </div>
                        <div class="results"></div>
                    </div>


                    <input id="editInput" type="text" placeholder="请输入修改内容" data-value="{{$activity->id}}"
                           data-type="{{$activity->type}}">

                    <div class="ui selection dropdown applyDetail">
                        <i class="dropdown icon"></i>
                        <div class="default text">请选择修改项</div>
                        <div class="menu">
                            <div class="item" data-value="message"
                                 data-content="{{$activity->activity_shops->message}}">
                                标题
                            </div>
                            <div class="item" data-value="button" data-content="{{$activity->activity_shops->button}}">
                                按钮
                            </div>
                            <div class="item" data-value="exp" data-content="{{$activity->activity_requires->exp}}">
                                经验条件
                            </div>
                            <div class="item" data-value="level" data-content="{{$activity->activity_requires->level}}">
                                等级条件
                            </div>
                            <div class="item" data-value="start_at" data-content="{{$activity->start_at}}">
                                开始时间
                            </div>
                            <div class="item" data-value="end_at" data-content="{{$activity->end_at}}">
                                结束时间
                            </div>
                            <div class="item" data-value="elect" data-content="{{$activity->elect}}">
                                筛选方式
                            </div>
                            <div class="item" data-value="article_id" data-content="{{$activity->article_id}}">
                                文章选择
                            </div>
                            <div class="item" data-value="link" data-content="{{$activity->activity_shops->link}}">
                                跳转链接
                            </div>

                            @if(!$activity->activity_shops->avatar_path)
                                <div class="item" data-value="image_path"
                                     data-content="{{$activity->activity_shops->image_path}}">
                                    @else
                                        <div class="item" data-value="image_path"
                                             data-content="{{$activity->activity_shops->image_path.",".$activity->activity_shops->avatar_path}}">
                                            @endif
                                            活动首页图
                                        </div>
                                </div>
                        </div>
                        <div id="applyDetailSubmit" class="ui button">修改</div>
                    </div>

                    <!--活动轮播图模块-->
                    <div class="ui segment clear-shadow yu-hidden uploadImage">
                        <div id="imageBox" class="ui two special cards headimg_box" data-limit="2">
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
                </div>

                <div class="six wide column p0" style="height: 700px;overflow: auto;">
                    {{--轮播图--}}
                    <div class="column flow">
                        <div class="ui attached top segment mt8 border-clear">
                            <div class="ui feed m0">
                                <div class="event">
                                    <div class="label">
                                        @if($activity->activity_shops->avatar_path)
                                            <img src="{{ asset($activity->activity_shops->avatar_path)}}">
                                        @else
                                            <img src="{{ asset('storage/headimg/default.png')}}">
                                        @endif
                                    </div>
                                    <div class="content m0">
                                        <div class="meta">
                                            {{$activity->activity_shops->message}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <img src="{{asset($activity->activity_shops->image_path)}}" alt="">
                            </div>
                        </div>
                        @if($activity->activity_shops->link !== null)
                            <a class="ui fluid compact attached bottom button"
                               href="{{url($activity->activity_shops->link)}}">
                                {{$activity->activity_shops->button}}
                            </a>
                        @else
                            <a class="ui fluid compact attached bottom button"
                               href="{{url('wechat/article/'.$activity->article_id)}}">
                                {{$activity->activity_shops->button}}
                            </a>
                        @endif
                    </div>
                    {{--轮播图end--}}

                    {{--活动内容--}}
                    <div class="column" style="background-color: white;">
                        <div class="mt8">
                            {!! $activity->articles->content or "" !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection