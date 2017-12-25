@extends('wechat.layout.frame-slide',['title' => "奖品兑换"])
@section('content')
    <body style="position: relative">
    <div class="ui one column grid columns feeds">

        {{--礼品券兑奖--}}
        @foreach($prizes as $prize)
            <div class="column feeds">
                <div class="ui attached top segment mt8 border-clear">
                    <div class="ui horizontal p0m0 grid">
                        <div class="five wide column p0 text-center">
                            <img class="cigarette" src="{{asset($prize->image_path)}}">
                        </div>
                        <div class="eleven wide column p0m0">
                            <div class="content p8">
                                <div class="summary">
                                    {{$prize->name}}
                                </div>

                                <div>总量：{{$prize->count}}
                                    剩余数量：{{ $prize->count - $prize->send_out }}
                                </div>
                                <div class="mt8">
                                    <i class="ui green ticket icon"></i>
                                    消耗礼品券数：
                                    <span>
                                            {{ $prize->cost}}张
                                    </span>
                                </div>
                                <div>
                                    <i class="ui green user icon"></i>
                                    已兑换数量：
                                    <span>
                                    {{$prize->send_out}}
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="ui fluid compact attached bottom button"
                   href="{{url('wechat/prize/getPrize').'/'.$prize->id}}">
                    兑换
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
