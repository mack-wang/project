@extends('wechat.layout.frame-slide',['title' => "博烟荟萃"])
@section('content')
    <body style="position: relative">
    <div class="ui one column grid columns feeds">
        {{--轮播图--}}
        <div class="column">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($slides as $slide)
                        <div class="swiper-slide">
                            <a href="{{$slide->redirect_path == null ? url('wechat/article/'.$slide->article_id) : url($slide->redirect_path)}}">
                                <img class="ui image" src="{{asset($slide->image_path)}}" alt="">
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        {{--轮播图end--}}

        <div class="column p0">
            <div class="ui segment">
                <div class="ui center aligned four column grid navigation">
                    <div class="column">
                        <a href="{{url('wechat/lottery')}}" class="item">
                            <i class="big orange yu-lottery icon"></i>
                            <div>幸运转盘</div>
                        </a>
                    </div>
                    <div class="column">
                        <a href="{{url('wechat/weather')}}" class="item">
                            <i class="big teal yu-weather icon"></i>
                            <div>旅行天气</div>
                        </a>
                    </div>
                    {{--<div class="column">--}}
                    {{--<a href="{{url('wechat/insurance')}}" class="item">--}}
                    {{--<i class="big teal yu-insurance icon"></i>--}}
                    {{--<div>领取保险</div>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    <div class="column">
                        <a href="{{url('wechat/guide')}}" class="item">
                            <i class="big blue yu-guide icon"></i>
                            <div>出行指南</div>
                        </a>
                    </div>
                    <div class="column">
                        <a href="{{url('wechat/apply/list')}}" class="item">
                            <i class="big green yu-apply icon"></i>
                            <div>免费试用</div>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{--个人中心--}}
        <div class="column ">
            <div class="ui segment personal border-clear  mt8">
                <div class="ui feed personal">
                    <div class="event">
                        <div class="label">
                            <img class="ui image" src="{{asset($user->user_wechats->headimgurl)}}">
                        </div>
                        @if(Auth::guard('wechat')->check())
                            <div class="content">
                                <div class="meta">
                                    <span>等级</span>
                                    <div class="ui tiny star rating test apply"
                                         data-rating="{{$user->user_infos->level}}"
                                         data-max-rating="5">
                                    </div>
                                    <a href="{{url('wechat/apply/person')}}">
                                        {{\App\Helper::$levelArray[($user->user_infos->level)-1]}}
                                    </a>
                                </div>
                                <div class="meta">
                                    <span>经验</span>
                                    <div class="ui tiny green indicating progress exp"
                                         data-value="{{$user->user_infos->exp}}"
                                         data-total="5000">
                                        <div class="bar"></div>
                                    </div>
                                    <span>{{$user->user_infos->exp}}点</span>
                                </div>
                            </div>
                            <a href="{{url('wechat/home')}}" class="feeds button">
                                个人中心
                            </a>
                        @elseif($user->register == 1)
                            <div class="content">
                                <div id="logout" class="summary pt10">
                                    {{$user->user_wechats->nickname}}
                                    未登入
                                </div>
                            </div>
                            <a href="{{url('wechat/home')}}" class="feeds button">
                                登入
                            </a>
                        @else
                            <div class="content">
                                <div id="logout" class="summary pt10">
                                    {{$user->user_wechats->nickname}}
                                    未注册
                                </div>
                            </div>
                            <a href="{{url('wechat/home')}}" class="feeds button">
                                注册
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{--个人中心end--}}

        {{--种草--}}
        {{--如果没有绑定终端，什么也不显示--}}
        @if(\App\Models\User::find(session("user_id"))->shop_id == null)

        @elseif(Auth::guard('wechat')->check())
            <div class="column">
                <div class="ui two item menu clear-shadow ">
                    @if($signIn)
                        <a class="item green-text"><i
                                    class="marker icon "></i>已签到+100点经验</a>
                    @else
                        <a href="{{url('wechat/getDaily')}}" class="item green-text"><i
                                    class="marker icon"></i>每日签到</a>
                    @endif
                    <a href="{{url('wechat/grass/index')}}" class="item green-text"><i class="leaf icon"></i> 每日种草</a>
                </div>
            </div>
        @else
            <div class="column">
                <div class="ui two item menu clear-shadow ">
                    <a href="{{url('wechat/login')}}" class="item green-text"><i class="marker icon"></i> 每日签到</a>
                    <a href="{{url('wechat/login')}}" class="item green-text"><i class="leaf icon"></i> 每日种草</a>
                </div>
            </div>
        @endif

        {{--种草end--}}

        <div class="column flow">
            <div class="ui attached top segment mt8 border-clear">
                <div class="ui feed m0">
                    <div class="event">
                        <div class="label">
                            <img src="{{ asset('img/flow/h1.jpg')}}">
                        </div>
                        <div class="content m0">
                            <div class="meta">
                                幸运大转盘
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <img src="{{asset('img/flow/lottery.png')}}" alt="">
                </div>
            </div>
            <a class="ui fluid compact attached bottom button"
               href="{{url('/wechat/lottery')}}">
                立即参与
            </a>
        </div>


        <div class="column flow">
            <div class="ui attached top segment mt8 border-clear">
                <div class="ui feed m0">
                    <div class="event">
                        <div class="label">
                            <img src="{{ asset('img/flow/h5.png')}}">
                        </div>
                        <div class="content m0">
                            <div class="meta">
                                旅行天气查询
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <img src="{{asset('img/flow/weather.png')}}" alt="">
                </div>
            </div>
            <a class="ui fluid compact attached bottom button"
               href="{{url('/wechat/weather')}}">
                查询天气
            </a>
        </div>

        {{--<div class="column flow">--}}
        {{--<div class="ui attached top segment mt8 border-clear">--}}
        {{--<div class="ui feed m0">--}}
        {{--<div class="event">--}}
        {{--<div class="label">--}}
        {{--<img src="{{ asset('img/flow/h3.png')}}">--}}
        {{--</div>--}}
        {{--<div class="content m0">--}}
        {{--<div class="meta">--}}
        {{--PICC健康保险有奖调查--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div>--}}
        {{--<img src="{{asset('img/flow/insurance.png')}}" alt="">--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<a class="ui fluid compact attached bottom button"--}}
        {{--href="{{url('/wechat/insurance')}}">--}}
        {{--参与有奖调查--}}
        {{--</a>--}}
        {{--</div>--}}

        <div class="column flow">
            <div class="ui attached top segment mt8 border-clear">
                <div class="ui feed m0">
                    <div class="event">
                        <div class="label">
                            <img src="{{ asset('img/flow/h2.png')}}">
                        </div>
                        <div class="content m0">
                            <div class="meta">
                                出行指南
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <img src="{{asset('img/flow/guide.png')}}" alt="">
                </div>
            </div>
            <a class="ui fluid compact attached bottom button"
               href="{{url('/wechat/guide')}}">
                点击查看
            </a>
        </div>

        <div class="column flow">
            <div class="ui attached top segment mt8 border-clear">
                <div class="ui feed m0">
                    <div class="event">
                        <div class="label">
                            <img src="{{ asset('img/flow/h4.png')}}">
                        </div>
                        <div class="content m0">
                            <div class="meta">
                                免费试用
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <img src="{{asset('img/flow/apply.jpg')}}" alt="">
                </div>
            </div>
            <a class="ui fluid compact attached bottom button"
               href="{{url('/wechat/apply/list')}}">
                我要参与
            </a>
        </div>

        {{--独有活动流--}}
        @if($activity_shops !== null)
            @foreach($activity_shops as $activity)
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
                                    <!-- {{$user->shops->name}} -->
                                    </div>
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
                    <a class="ui fluid compact attached bottom button"
                       href="{{$activity->activity_shops->link != null ? url($activity->activity_shops->link):url('wechat/article/'.$activity->article_id)}}">
                        {{$activity->activity_shops->button or '立即参加'}}
                    </a>
                </div>
            @endforeach
        @endif
        {{--独有活动流end--}}
        {{--警示提示--}}
        <div class="column">
            <div class="ui segment">
                <div class="ui center aligned container m28 pb100 warning-tips">
                    <img class="ui centered mini image" src="{{asset('img/wechat/police.png')}}" alt="">
                    <div>网站备案/许可证号:浙ICP备16015140号</div>
                </div>
            </div>
        </div>
    </div>

    </body>
    <script>
        $('.progress').progress();

        var mySwiper = new Swiper('.swiper-container', {
            autoplay: 5000,
            speed: 1000,
            direction: 'horizontal',
            loop: true,
            pagination: '.swiper-pagination',
            paginationType: 'bullets'
        });

        $(".column.flow").find("img:eq(1)").click(function () {
            location.href = $(this).parent().parent().next().attr('href');
        })

    </script>
@endsection
