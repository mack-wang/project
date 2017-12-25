@extends('wechat.layout.frame-slide',['title' => "测评报告"])
@section('content')
    <body>
    <div class="ui one column grid columns feeds">
        {{--轮播图--}}
        <div class="column">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach(str_getcsv($activity->activity_headimgs->image_path) as $image_path)
                        <div class="swiper-slide">
                            <img class="ui image slide" src="{{asset($image_path)}}" alt="">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        {{--轮播图end--}}


        {{--活动内容--}}
        <div class="column">
            <div class="ui red inverted three item menu apply clear-shadow clear-radio">
                <div class="fitted item">
                    <div>
                        <div class="lighter text">试用名额</div>
                        <div>{{$activity->activity_prizes->count}}个</div>
                    </div>
                </div>
                <div class="fitted item">
                    <div>
                        <div class="lighter text">申请条件</div>
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
                        <div class="lighter text">活动结束</div>
                        <div>
                            查看评价报告
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--活动标题--}}
        <div class="column">
            <div class="ui segment">
                <div class="ui small lighter header p8">
                    <i class="red yu-fire icon p0m0"></i>
                    {{$activity->activity_attrs->title}}
                </div>
            </div>
        </div>
        {{--活动标题end--}}


        {{--奖品描述--}}
        @include("admin.layout.prize-description")
        {{--奖品描述end--}}
        <div class="column">
            <div class="ui segment border-clear" style="padding: 10px!important;">
                <div class="ui green four item menu borderless m0 clear-shadow ">
                    <div class="item active">立即秒杀</div>
                    <div class="item active">秒杀成功</div>
                    <div class="item {{$activity->elect == 2 ? " active" : " " }}"  >邮寄产品</div>
                    <div class="item {{!$users ? " active" : " " }}" >试用评价</div>
                </div>
            </div>
        </div>

        {{--申领测评成功名单--}}
        <div class="column">
            <div class="ui segment mt8">
                <h4 style="padding: 10px 0 0 10px">申请成功名单</h4>
                <div class="ui container mb20">
                    <div class="ui four cards apply-success">
                        @if($activity->elect == 0)
                            <div class="ui info message m28">
                                电脑君正在从申请用户中随机筛选试用者，最多只需要花5分钟的时间，敬请期待。
                            </div>
                        @elseif($activity->elect == 1)
                            <div class="ui info message m28">
                                后台正在从申请用户中筛选试用者，敬请期待。
                            </div>
                        @else
                            @foreach($users as $user)
                                <div class="card">
                                    <div class="image">
                                        <img src="{{asset($user->user_wechats->headimgurl)}}"/>
                                    </div>
                                    <div class="extra">
                                        {{$user->user_wechats->nickname}}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{--申领测评成功名单end--}}


        {{--测评报告--}}
        @if($activity->elect == 2)
            <div class="column">
                <div class="ui segment mt8">
                    @if(!$reports->isEmpty())
                        <div class="ui comments m8">
                            @foreach($reports as $report)
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
                                                <a href="{{url("wechat/report/good/".$report->id)}}"
                                                   id="reportGood" class="fr" style="color:#3788b7;opacity: 0.5;">
                                                    <i class="large yu-good-o icon"></i>
                                                    <span class="f14">{{$report->goods}}</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="ui divider" style="border-top: 1px solid rgba(34,36,38,.05);"></div>
                            @endforeach

                            @else
                                <div class="ui info message m28">
                                    用户暂时还没上传评价报告
                                </div>
                            @endif
                        </div>
                </div>
                @endif
                {{--测评报告end--}}

            {{--活动内容--}}
            <div class="column" style="background-color: white;">
                <div class="mt8">
                    {!! $activity->articles->content !!}
                </div>
            </div>
            {{--活动内容end--}}



            {{--活动规则及流程--}}
            @include('wechat.layout.record')
            {{--活动规则及流程end--}}
        </div>
    </div>
    <div class="ui basic modal" id="preview">
        <img src="" alt="" style="width: 100%">
    </div>
    <script>
        var mySwiper = new Swiper('.swiper-container', {
            autoplay: 5000,
            speed: 1000,
            direction: 'horizontal',
            loop: true,
            pagination: '.swiper-pagination',
            paginationType: 'bullets'
        });
    </script>

    </body>
@endsection