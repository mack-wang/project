@extends('wechat.layout.frame-slide')
@section('content')
    <body style="position: relative">
    <div class="ui one column grid columns feeds">
        {{--轮播图--}}
        <div class="column">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($slides as $slide)
                        <div class="swiper-slide">
                            <a href="{{url($slide->redirect_path)}}">
                                <img class="ui image" src="{{asset($slide->image_path)}}" alt="">
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        {{--轮播图end--}}

        {{--个人中心--}}
        <div class="column ">
            <div class="ui segment personal border-clear">
                <div class="ui feed personal">
                    <div class="event">
                        <div class="label">
                            <img class="ui image" src="{{asset($visitor->headimgurl)}}">
                        </div>
                        @if( $user != null )
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
                                    <div class="ui tiny green indicating progress exp"
                                         data-value="{{$user->user_infos->exp}}"
                                         data-total="1000">
                                        <div class="bar"></div>
                                    </div>
                                    <span>{{$user->user_infos->exp}}点</span>
                                </div>
                            </div>
                            <a href="{{url('wechat/home')}}" class="feeds button">
                                个人中心
                            </a>
                        @else
                            <div class="content">
                                <div id="logout" class="summary pt10">
                                    {{$visitor->nickname}}
                                    未登入
                                </div>
                            </div>
                            <a href="{{url('wechat/home')}}" class="feeds button">
                                登入
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{--个人中心end--}}

        {{--种草--}}
        <div class="column">
            <div class="ui segment mt8 border-clear">
                <div class="ui feed grass">
                    <div class="event">
                        <div class="content">
                            <div class="meta">
                                <span id="grass-message">嘿，给我浇水能增加经验哦！</span>
                            </div>
                        </div>
                        <div class="label">
                            <img class="ui image" src="{{asset('img/wechat/grass2.png')}}">
                        </div>
                        @if($user !=null)
                            <a href="{{url('wechat/grass/index')}}"
                               class="feeds button">
                                去种草
                            </a>
                        @else
                            <a href="{{url('wechat/login')}}"
                               class="feeds button">
                                去种草
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{--种草end--}}

        {{--独有活动流--}}
        @foreach($activity_shops as $activity)
            <div class="column flow">
                <div class="ui attached top segment mt8 border-clear">
                    <div class="ui feed m0">
                        <div class="event">
                            <div class="label">
                                @if(\App\Models\ShopHeadimg::where('shop_id',$shop->id)->exists())
                                    <img src="{{ asset(\App\Models\ShopHeadimg::find($shop->id)->image_path)}}">
                                @else
                                    <img src="{{ asset('storage/headimg/default.png')}}">
                                @endif

                            </div>
                            <div class="content m0">
                                <div class="meta">
                                    {{$shop->name}}
                                </div>
                                <div class="meta">
                                    {{$activity->message}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <img src="{{asset($activity->image_path)}}" alt="">
                    </div>
                </div>
                @if($activity->link != null)
                    <a class="ui fluid compact attached bottom button"
                       href="{{url($activity->link)}}">
                        {{$activity->button}}
                    </a>
                @else
                    <a class="ui fluid compact attached bottom button"
                       href="{{url('wechat/activity/show').'/'.$activity->activities->type.'/'.$activity->activity_id}}">
                        {{$activity->button}}
                    </a>
                @endif
            </div>
        @endforeach
        {{--独有活动流end--}}

        {{--共同活动流--}}
        {{--申领活动--}}
        @foreach($activity_applies as $activity)
            <div class="column feeds">
                <div class="ui attached top segment mt8 border-clear">
                    <div class="ui horizontal p0m0 grid">
                        <div class="five wide column p0 text-center">
                            <img class="cigarette" src="{{asset($activity->fetch_cigarettes->image_url)}}">
                        </div>
                        <div class="eleven wide column p0m0">
                            <div class="content p8">
                                <div class="summary">
                                    {{$activity->activity_attrs->title}}
                                    @if($activity->activity_requires->exp != null)
                                        <div class="ui mini red horizontal label">
                                            {{$activity->activity_requires->exp}}点
                                        </div>
                                    @endif
                                    @if($activity->activity_requires->level != null)
                                        <div class="ui mini yellow horizontal label">
                                            {{$activity->activity_requires->level}}星
                                        </div>
                                    @endif
                                </div>

                                <div>数量：{{$activity->activity_prizes->count}}包
                                    市场价：{{$activity->fetch_cigarettes->price/10}}
                                    元/包
                                </div>
                                <div class="mt8">
                                    <i class="ui green hourglass half icon"></i>
                                    申领倒计时：
                                    <span>
                                            {{ \App\Helper::secondToDate(strtotime($activity->end_at)-time()) }}
                                    </span>
                                </div>
                                <div>
                                    <i class="ui green user icon"></i>
                                    当前申领测评人数：
                                    <span>
                                    {{$activity->result_applies->count()}}人
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="ui fluid compact attached bottom button"
                   href="{{url('wechat/activity/show').'/'.$activity->type.'/'.$activity->id}}">
                    立即申领
                </a>
            </div>
        @endforeach
        {{--申领活动end--}}

        {{--秒杀活动--}}
        @foreach($activity_kills as $activity)
            <div class="column feeds">
                <div class="ui attached top segment mt8 border-clear">
                    <div class="ui horizontal p0m0 grid">
                        <div class="five wide column p0 text-center">
                            <img class="cigarette" src="{{asset($activity->fetch_cigarettes->image_url)}}">
                        </div>
                        <div class="eleven wide column p0m0">
                            <div class="content p8">
                                <div class="summary">
                                    {{$activity->activity_attrs->title}}
                                    @if($activity->activity_requires->exp != null)
                                        <div class="ui mini red horizontal label">
                                            {{$activity->activity_requires->exp}}点
                                        </div>
                                    @endif
                                    @if($activity->activity_requires->level != null)
                                        <div class="ui mini yellow horizontal label">
                                            {{$activity->activity_requires->level}}星
                                        </div>
                                    @endif
                                </div>

                                <div>数量：{{$activity->activity_prizes->count}}包
                                    市场价：{{$activity->fetch_cigarettes->price/10}}
                                    元/包
                                </div>
                                <div class="mt8">
                                    <i class="ui green hourglass half icon"></i>
                                    秒杀倒计时：
                                    @if(strtotime($activity->start_at)-time()>0 )
                                        <span class="count-down" data-value="{{strtotime($activity->start_at)-time()}}">
                                            <span class="time2"></span>:
                                            <span class="time2"></span>:
                                            <span class="time2"></span>:
                                            <span class="time2"></span>
                                        </span>
                                    @else
                                        <span>
                                                秒杀活动正在进行
                                            </span>
                                    @endif
                                </div>
                                <div>
                                    <i class="ui green user icon"></i>
                                    秒杀开启时间：
                                    <span>
                                    {{date('m月d日 H:i:s',strtotime($activity->start_at))}}
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="ui fluid compact attached bottom button"
                   href="{{url('wechat/activity/show').'/'.$activity->type.'/'.$activity->id}}">
                    参与秒杀
                </a>
            </div>
        @endforeach
        {{--秒杀活动end--}}

        {{--测评报告流--}}
        @foreach($reports as $activity)
            <div class="column feeds ">
                <div class="ui attached top segment mt8 border-clear">
                    <div class="ui horizontal p0m0 grid relative">

                        <div class="five wide column p0 text-center">
                            <img class="cigarette" src="{{asset($activity->fetch_cigarettes->image_url)}}">
                        </div>
                        <div class="eleven wide column p0m0">
                            <div class="content p8">
                                <div class="summary">
                                    {{$activity->activity_attrs->title}}
                                    @if($activity->activity_requires->exp != null)
                                        <div class="ui mini red horizontal label">
                                            {{$activity->activity_requires->exp}}点
                                        </div>
                                    @endif
                                    @if($activity->activity_requires->level != null)
                                        <div class="ui mini yellow horizontal label">
                                            {{$activity->activity_requires->level}}星
                                        </div>
                                    @endif
                                </div>

                                <div>数量：{{$activity->activity_prizes->count}}包
                                    市场价：{{$activity->fetch_cigarettes->price/10}}
                                    元/包
                                </div>

                                @if($activity->type == "apply")
                                    <div class="mt8">
                                        <i class="ui green user icon"></i>
                                        申领测评人数：
                                        <span>

                                            {{ $activity->result_applies->count() }}人
                                    </span>
                                    </div>
                                    <div>
                                        <i class="ui green user icon"></i>
                                        成功申领人数：
                                        <span>
                                            {{ \App\Models\ResultApply::where('activity_id',$activity->id)
                                            ->where('status',1)
                                            ->count()
                                           }}人
                                        </span>
                                    </div>
                                @else
                                    <div class="mt8">
                                        <i class="ui green user icon"></i>
                                        申领测评人数：
                                        <span>

                                            {{ $activity->result_kills->count() }}人
                                    </span>
                                    </div>
                                    <div>
                                        <i class="ui green user icon"></i>
                                        成功申领人数：
                                        <span>
                                           {{ \App\Models\ResultKill::where('activity_id',$activity->id)
                                               ->where('status',1)
                                               ->count()
                                            }}人
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <img src="{{asset("img/wechat/seal.png")}}" class="seal">
                    </div>
                </div>
                <a class="ui fluid compact attached bottom button"
                   href="{{url('wechat/activity/show').'/'.$activity->type.'/'.$activity->id.'/report'}}">
                    查看测评报告
                </a>
            </div>
        @endforeach

        {{--测评报告流end--}}
    </div>
    {{--共同活动流end--}}

    {{--烟草警示弹窗--}}
    <div class="ui warning modal">
        <div class="ui green header">警示</div>
        <div class="content">
            <p style="font-size: 20px;color:#009A44">本页面含有烟草信息，如果您未满18周岁，敬请回避！</p>
        </div>
        <div class="actions">
            <div class="ui green approve button">确认</div>
            <div class="ui cancel button">退出</div>
        </div>
    </div>
    {{--烟草警示弹窗end--}}

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


        $("#logout").click(function () {
            $.get('{{url("wechat/logout")}}');
            alert("退出登入成功");
        })

    </script>
@endsection