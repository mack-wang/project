@extends('wechat.layout.frame-slide',['title' => "兑奖二维码"])
@section('content')
    <body style="position: relative">
    @if($prizes->isEmpty())
        <div class="ui info message m28">您暂时还没有邮寄奖品</div>
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
                                <a class="summary">
                                    {{$prize->qrcode_prizes->name}}

                                    {{--邮寄奖品--}}
                                    @if($prize->qrcode_prizes->kind === null)
                                        @if($prize->status === 1)
                                            <div class="ui tiny label">已邮寄</div>
                                        @else
                                            <div class="ui red tiny label">未邮寄</div>
                                        @endif
                                    @endif

                                    {{--手机充值奖品--}}
                                    @if($prize->qrcode_prizes->kind === "charge")
                                        @if($prize->status === 1)
                                            <div class="ui green tiny label">正在充值中</div>
                                        @elseif($prize->status === 2)
                                            <div class="ui tiny label">已充值</div>
                                        @else
                                            <a href="{{url('wechat/charge/id/'.$prize->id)}}" class="ui red tiny label">点击领取</a>
                                @endif
                                @endif

                            </div>
                            <div class="mt8">
                                获奖时间：
                                <span>
                                    {{$prize->created_at}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @endforeach
    </div>

    {{--申领活动end--}}

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
