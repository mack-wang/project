@extends('wechat.layout.frame-slide',['title' => "免费试用"])
@section('content')
    <body style="position: relative">
    <div class="ui one column grid columns feeds">
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

                                <div>@if(!$activity->fetch_cigarettes->status)
                                        数量：{{$activity->activity_prizes->count}}包
                                        市场价：{{$activity->fetch_cigarettes->price/10}}元/包
                                    @else
                                        数量：{{$activity->activity_prizes->count}}个
                                        市场价：{{$activity->fetch_cigarettes->price}}元/个
                                    @endif
                                </div>
                                <div class="mt8">
                                    <i class="ui green hourglass half icon"></i>
                                    申请倒计时：
                                    <span>
                                            {{ \App\Helper::secondToDate(strtotime($activity->end_at)-time()) }}
                                    </span>
                                </div>
                                <div>
                                    <i class="ui green user icon"></i>
                                    当前申请试用人数：
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
                    立即申请
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

                                <div>
                                    @if(!$activity->fetch_cigarettes->status)
                                        数量：{{$activity->activity_prizes->count}}包
                                        市场价：{{$activity->fetch_cigarettes->price/10}}元/包
                                    @else
                                        数量：{{$activity->activity_prizes->count}}个
                                        市场价：{{$activity->fetch_cigarettes->price}}元/个
                                    @endif
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

                                <div>@if(!$activity->fetch_cigarettes->status)
                                        数量：{{$activity->activity_prizes->count}}包
                                        市场价：{{$activity->fetch_cigarettes->price/10}}元/包
                                    @else
                                        数量：{{$activity->activity_prizes->count}}个
                                        市场价：{{$activity->fetch_cigarettes->price}}元/个
                                    @endif
                                </div>

                                @if($activity->type == "apply")
                                    <div class="mt8">
                                        <i class="ui green user icon"></i>
                                        申请试用人数：
                                        <span>

                                            {{ $activity->result_applies->count() }}人
                                    </span>
                                    </div>
                                    <div>
                                        <i class="ui green user icon"></i>
                                        成功申请人数：
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
                                        申领试用人数：
                                        <span>

                                            {{ $activity->result_applies->count() }}人
                                    </span>
                                    </div>
                                    <div>
                                        <i class="ui green user icon"></i>
                                        成功申请人数：
                                        <span>
                                           {{ \App\Models\ResultApply::where('activity_id',$activity->id)
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
                    查看评价报告
                </a>
            </div>
        @endforeach

        {{--过期活动--}}
        <div class="column feeds">
            <img src="{{asset('img/wechat/previous.png')}}" class="fullwidth" alt="">
        </div>

        <div class="column feeds ">
            <div class="ui attached top segment border-clear" style="margin-top: -4px;">
                <div class="ui horizontal p0m0 grid relative">

                    <div class="five wide column p0 text-center">
                        <img class="cigarette" src="{{asset('img/wechat/guo.png')}}">
                    </div>
                    <div class="eleven wide column p0m0">
                        <div class="content p8">
                            <div class="summary">
                                荣事达电蒸锅
                                <div class="ui mini red horizontal label">
                                    3星
                                </div>
                            </div>

                            <div>
                                数量：10个
                                市场价：158元/个
                            </div>
                            <div class="mt8">
                                <i class="ui green user icon"></i>
                                申请试用人数：
                                <span>320人</span>
                            </div>
                            <div>
                                <i class="ui green user icon"></i>
                                成功申请人数：
                                <span>10人</span>
                            </div>
                        </div>
                    </div>
                    <img src="{{asset("img/wechat/end.png")}}" class="seal">
                </div>
            </div>
        </div>

        <div class="column feeds ">
            <div class="ui attached top segment mt8 border-clear">
                <div class="ui horizontal p0m0 grid relative">

                    <div class="five wide column p0 text-center">
                        <img class="cigarette" src="{{asset('img/wechat/zheng.png')}}">
                    </div>
                    <div class="eleven wide column p0m0">
                        <div class="content p8">
                            <div class="summary">
                                便携U型枕
                                <div class="ui mini yellow horizontal label">
                                    1星
                                </div>
                            </div>

                            <div>
                                数量：20个
                                市场价：30元/个
                            </div>
                            <div class="mt8">
                                <i class="ui green user icon"></i>
                                申请试用人数：
                                <span>322人</span>
                            </div>
                            <div>
                                <i class="ui green user icon"></i>
                                成功申请人数：
                                <span>20人</span>
                            </div>
                        </div>
                    </div>
                    <img src="{{asset("img/wechat/end.png")}}" class="seal">
                </div>
            </div>
        </div>


        <div class="column feeds ">
            <div class="ui attached top segment mt8 border-clear">
                <div class="ui horizontal p0m0 grid relative">

                    <div class="five wide column p0 text-center">
                        <img class="cigarette" src="{{asset('img/wechat/tea.png')}}">
                    </div>
                    <div class="eleven wide column p0m0">
                        <div class="content p8">
                            <div class="summary">
                                印象香草茶
                                <div class="ui mini red horizontal label">
                                    500点
                                </div>
                            </div>

                            <div>
                                数量：10个
                                市场价：88元/个
                            </div>
                            <div class="mt8">
                                <i class="ui green user icon"></i>
                                申请试用人数：
                                <span>268人</span>
                            </div>
                            <div>
                                <i class="ui green user icon"></i>
                                成功申请人数：
                                <span>10人</span>
                            </div>
                        </div>
                    </div>
                    <img src="{{asset("img/wechat/end.png")}}" class="seal">
                </div>
            </div>
        </div>

        <div class="column feeds ">
            <div class="ui attached top segment mt8 border-clear">
                <div class="ui horizontal p0m0 grid relative">

                    <div class="five wide column p0 text-center">
                        <img class="cigarette" src="{{asset('img/wechat/frwpic.png')}}">
                    </div>
                    <div class="eleven wide column p0m0">
                        <div class="content p8">
                            <div class="summary">
                                芙蓉王硬闪带75mm
                                <div class="ui mini red horizontal label">
                                    500点
                                </div>
                            </div>

                            <div>
                                数量：10个
                                市场价：40元/包
                            </div>
                            <div class="mt8">
                                <i class="ui green user icon"></i>
                                申请试用人数：
                                <span>161人</span>
                            </div>
                            <div>
                                <i class="ui green user icon"></i>
                                成功申请人数：
                                <span>10人</span>
                            </div>
                        </div>
                    </div>
                    <img src="{{asset("img/wechat/end.png")}}" class="seal">
                </div>
            </div>
        </div>

        <div class="column feeds ">
            <div class="ui attached top segment mt8 border-clear" style="border-bottom: 1px solid #eee!important;">
                <div class="ui horizontal p0m0 grid relative">

                    <div class="five wide column p0 text-center">
                        <img class="cigarette" src="{{asset('img/wechat/htxpic.jpg')}}">
                    </div>
                    <div class="eleven wide column p0m0">
                        <div class="content p8">
                            <div class="summary">
                                白沙和天下
                                <div class="ui mini yellow horizontal label">
                                    3星
                                </div>
                            </div>

                            <div>
                                数量：10个
                                市场价：100元/包
                            </div>
                            <div class="mt8">
                                <i class="ui green user icon"></i>
                                申请试用人数：
                                <span>450人</span>
                            </div>
                            <div>
                                <i class="ui green user icon"></i>
                                成功申请人数：
                                <span>10人</span>
                            </div>
                        </div>
                    </div>
                    <img src="{{asset("img/wechat/end.png")}}" class="seal">
                </div>
            </div>
        </div>


        {{--测评报告流end--}}
    </div>
    {{--共同活动流end--}}

    <div class="column">
        <div class="ui segment clear-shadow border-clear">
            <div class="ui center aligned container m28 pb100 warning-tips">
                <img class="ui centered mini image" src="{{asset('img/wechat/police.png')}}" alt="">
                <div>网站备案/许可证号:浙ICP备16015140号</div>
                <div>本页面含有烟草信息，敬请18岁以下人士回避</div>
                <div>吸烟有害健康</div>
            </div>
        </div>
    </div>


    <a href="{{url('wechat/apply')}}" class="ui fluid green button absolute bottom">返回首页</a>

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
@endsection
