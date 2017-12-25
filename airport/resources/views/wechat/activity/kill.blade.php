@extends('wechat.layout.frame-slide')
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
                        <div class="lighter text">试用条件</div>
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
                        @if(strtotime($activity->start_at)<time() && strtotime($activity->end_at)>time())
                            <div class="lighter text">秒杀正在进行</div>
                        @endif
                        @if(strtotime($activity->start_at)-time()>0  )
                            <span>
                                    秒杀活动还未开始
                            </span>
                        @elseif(strtotime($activity->end_at)-time()>0)
                            <span class="count-down" data-value="{{strtotime($activity->end_at)-time()}}">
                                <span class="time2" style="background-color: white;color:red;"></span>:
                                <span class="time2" style="background-color: white;color:red;"></span>:
                                <span class="time2" style="background-color: white;color:red;"></span>:
                                <span class="time2" style="background-color: white;color:red;"></span>
                            </span>
                        @else
                            <span>
                                     秒杀活动已经结束
                            </span>
                        @endif
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
                    <div class="item {{$applied ? "active" : ""}}">秒杀成功</div>
                    <div class="item">邮寄产品</div>
                    <div class="item">试用评价</div>
                </div>
            </div>
        </div>

        {{--活动内容--}}
        <div class="column" style="background-color: white;">
            <div class="mt8">
                {!! $activity->articles->content !!}
            </div>
        </div>
        {{--活动内容end--}}


        {{--活动规则及流程--}}
        @include('wechat.layout.rule')
        {{--活动规则及流程end--}}

        {{--活动规则及流程--}}
        @include('wechat.layout.record')
        {{--活动规则及流程end--}}
    </div>


    <div class="ui bottom fixed three item apply menu">
        <div class="fitted item">
            <div>
                <div class="lighter text">市场价</div>
                <div class="strong text">{{$activity->fetch_cigarettes->status ? $activity->fetch_cigarettes->price."元/个" : ($activity->fetch_cigarettes->price/10)."元/包"}}</div>
            </div>
        </div>
        <div class="fitted item">
            <div>
                <div class="lighter text">秒杀成功</div>
                <div class="strong text">{{$activity->result_applies->count()}}人</div>
            </div>
        </div>
        @if(!$applied)
            <div id="apply" class="item applied">
                立即秒杀
            </div>
        @else
            <div class="item applied">
                秒杀成功
            </div>
        @endif
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

        $('#apply').click(function () {
            if ($('.agreement.checkbox').checkbox('is unchecked')) {
                alert("请确认已经阅读活动规则！");
                return false;
            }

            $.get('{{url("wechat/activity/require_kill")."/".$activity->id}}', function (auth) {
                switch (auth) {
                    case "unlogin":
                        location.href = "{{url('wechat/login')}}";
                        break;

                    case "shop_error":
                        alert("你未绑定终端，不可以参与申请试用。用微信扫终端二维码，即可绑定。");
                        break;
                    case "exp_error":
                        alert("你的经验未达到{{$activity->activity_requires->exp}}点以上,不能参与。可以到首页上的去种草，增加经验哦！");
                        break;
                    case "level_error":
                        alert("你的等级未达到{{$activity->activity_requires->level}}星以上,不能参与。可以到首页上的去种草，增加等级哦！");
                        break;
                    case "fail":
                        alert("真遗憾，试用产品已经被抢完了");
                        break;
                    case "success":
                        $("#apply").text("秒杀成功").off('click');
                        alert("秒杀成功");
                        break;
                }
            })
        })

    </script>

    </body>
@endsection