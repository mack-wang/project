@extends('wechat.layout.frame-slide',['title' => "兑奖二维码"])
@section('content')
    <body style="position: relative">

    {{--礼品券兑奖--}}
    <div class="ui container mt8" style="padding-bottom: 60px ;">
            <div class="ui fluid card">
                <div class="image">
                    <img src="{{asset($qrcode->qrcode_paths->qrcode_path)}}">
                </div>
                <div class="content">
                    <a class="header f16" style="display: inline-block">{{$qrcode->qrcode_prizes->name}}</a>
                    @if($qrcode->state === 1)
                        <div class="ui tiny label">已兑换</div>
                    @elseif($qrcode->state === 0 && time()<strtotime($qrcode->end_at))
                        <div class="ui green  tiny label">未兑换</div>
                    @else
                        <div class="ui red  tiny label">已过期</div>
                    @endif
                    <div class="meta">
                        <span class="date">兑换截止日期：{{$qrcode->end_at}}</span>
                    </div>

                </div>
                <div class="extra content">
                    <a>
                        <i class="home icon"></i>
                        兑换点：{{$qrcode->shops->name}}
                    </a>
                </div>
            </div>
        {{--申领活动end--}}
        <div class="m8">
            @include('wechat.layout.message')
        </div>
    </div>


    <a href="{{url('wechat/prize/prize_list')}}" class="ui fluid green button absolute bottom">返回个人中心</a>
    </body>
@endsection
