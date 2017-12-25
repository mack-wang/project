@extends('wechat.layout.frame-slide',['title' => "兑奖二维码"])
@section('content')
    <body style="position: relative">
    @if($prizes->isEmpty())
        <div class="ui info message m28">您暂时还没有兑奖二维码</div>
    @endif
    <div class="ui one column grid columns feeds">
        {{--礼品券兑奖--}}
        @foreach($prizes as $prize)
            <div class="column feeds">
                <div class="ui attached top segment mt8 border-clear">
                    <div class="ui horizontal p0m0 grid">
                        <div class="five wide column p0 text-center">
                            <img class="cigarette" src="{{asset($prize->qrcode_prizes->image_path)}}">
                        </div>
                        <div class="eleven wide column p0m0">
                            <div class="content p8">
                                <div class="summary">
                                    {{$prize->qrcode_prizes->name}}
                                    @if($prize->state === 1)
                                        <div class="ui tiny label">已兑换</div>
                                    @elseif($prize->state === 0 && time()<strtotime($prize->end_at))
                                        <div class="ui green  tiny label">未兑换</div>
                                    @else
                                        <div class="ui red  tiny label">已过期</div>
                                    @endif
                                </div>

                                <div>
                                    兑换点：{{$prize->shops->name}}
                                </div>
                                <div class="mt8">
                                    <i class="ui green ticket icon"></i>
                                    消耗礼品券数：
                                    <span>
                                            {{ $prize->qrcode_prizes->cost}}张
                                    </span>
                                </div>
                                <div>
                                    <i class="ui green user icon"></i>
                                    兑换截止时间：
                                    <span>
                                    {{$prize->end_at}}
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="ui fluid compact attached bottom button"
                   href="{{url('wechat/prize/showQrcode').'/'.$prize->qrcode_paths->hashids}}">
                    查看兑奖二维码
                </a>
            </div>

        @endforeach
        {{--申领活动end--}}
    </div>
    <div class="text-center mt8">
        {{$prizes->links()}}
    </div>
    <div class="m8">
        @include('wechat.layout.message')
    </div>
    <div style="width: 100%;height: 50px;"></div>
    <a href="{{url('wechat/home')}}" class="ui fluid green button absolute bottom">返回个人中心</a>
    </body>
@endsection
