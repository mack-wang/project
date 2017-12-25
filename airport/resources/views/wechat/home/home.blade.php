@extends('wechat.layout.frame',['title' => "个人中心"])
@section('content')
    <body>
    <div class="ui one column grid columns feeds">
        {{--个人中心--}}
        <div class="column">
            <div class="ui segment mt8">
                <div class="ui feed">
                    <div class="event">
                        <div class="label" style="width: 50px;padding-top: 4px;">
                            <img class="ui  image" src="{{$user->user_wechats->headimgurl}}">
                        </div>
                        <div class="content">
                            <div class="summary">
                                {{$user->user_wechats->nickname}}
                            </div>
                            <div class="meta">
                                {{$user->user_infos->phone}}
                            </div>
                        </div>
                        <a href="{{url('wechat/login/view/password-reset')}}" class="feeds button">
                            修改密码
                        </a>
                        <a href="{{url('wechat/logout')}}" class="feeds button">
                            退出登入
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{--个人中心end--}}
        <div class="column">
            <div class="ui segment mt8">
                <div class="ui feed ">
                    <div class="event">
                        <div class="label" style="padding-top: 2px;">
                            <i class="ui yellow star icon"></i>
                        </div>
                        <div class="content">
                            <div class="summary">
                                {{$user->user_infos->level}}星{{$levels->where('id', $user->user_infos->level)->pluck('name')[0]}}
                            </div>
                        </div>
                        <a class="feeds level-explain button adjust">
                            提高等级
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="ui segment" style="margin-top: -1px;">
                <div class="ui feed">
                    <div class="event">
                        <div class="label" style="padding-top: 2px;">
                            <i class="ui red heart icon"></i>
                        </div>
                        <div class="content">
                            <div class="summary">
                                {{$user->user_infos->exp}}点经验
                            </div>
                        </div>
                        <a class="feeds exp-explain button adjust">
                            增加经验
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{--礼品券--}}
        <div class="column">
            <div class="ui segment" style="margin-top: -1px;">
                <div class="ui feed">
                    <div class="event">
                        <div class="label" style="padding-top: 2px;">
                            <i class="ui green ticket icon"></i>
                        </div>
                        <div class="content">
                            <div class="summary">
                                {{$user->user_infos->ticket}}张礼品券
                            </div>
                        </div>
                        {{--<a href="{{url('wechat/prize/show')}}" class="feeds button adjust">--}}
                             {{--使用礼品券--}}
                        {{--</a>--}}
                        <a  class="feeds button adjust" style="color:gray;">
                             暂未开放
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{--邀请记录--}}
        <div class="column">
            <div class="ui segment" style="margin-top: -1px;">
                <div class="ui feed">
                    <div class="event">
                        <div class="label" style="padding-top: 2px;">
                            <i class="ui green user icon"></i>
                        </div>
                        <div class="content">
                            <div class="summary">
                                累计邀请了{{\App\Models\UserRecommend::where('recommend_id',$user->id)->count()}}位好友
                            </div>
                        </div>
                        <a class="feeds invite-friend button adjust">
                            邀请好友
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{--邀请记录end--}}



        <div class="column">
            <div class="ui segment mt8" style="margin-top: -1px;">
                <div class="ui feed">
                    <div class="event">
                        <div class="label" style="padding-top: 2px;">
                            <i class="ui teal edit icon"></i>
                        </div>
                        <div class="content">
                            <div class="summary">
                                修改资料
                            </div>
                        </div>
                        <a href="{{url('wechat/home/view/address')}}" class="feeds button adjust">
                            修改资料
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{--申领记录--}}
        <div class="column">
            <div class="ui segment mt8">
                <div class="ui feed ">
                    <div class="event">
                        <div class="label" style="padding-top: 2px;">
                            <i class="ui green newspaper icon"></i>
                        </div>
                        <div class="content">
                            <div class="summary">
                                <div>申请记录</div>
                            </div>
                            @if(!$applies->isEmpty())
                                <div class="meta">
                                    <div class="ui list">
                                        @foreach($applies as $apply )
                                            <a class="item">
                                                {{str_limit($apply->activity_attrs->title,32)}}
                                                <br>
                                                {{date('Y-m-d',strtotime($apply->created_at))}}
                                                @if($apply->status === null)
                                                    进行中
                                                @elseif($apply->status === 0)
                                                    未选中
                                                @elseif($apply->status === 1)
                                                    申请成功
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        <a href="{{url('wechat/home/apply-list')}}" class="feeds button adjust">
                            查看更多
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{--申领记录end--}}


        {{--我的测评报告--}}
        <div class="column">
            <div class="ui segment mt8">
                <div class="ui feed ">
                    <div class="event">
                        <div class="label" style="padding-top: 2px;">
                            <i class="ui green file text icon"></i>
                        </div>
                        <div class="content">
                            <div class="summary">
                                <div>我的评价报告</div>
                            </div>
                            @if(!$applyReports->isEmpty())
                                <div class="meta">
                                    <div class="ui list">
                                        @foreach($applyReports as $report)
                                            <div class="item">{{str_limit($report->activity_attrs->title,32)}} <br>
                                                {{date('Y-m-d',strtotime($report->created_at))}}
                                                @if($report->reports === null)
                                                    <a style="color:red;"
                                                       href="{{url('wechat/report/write/'.$report->activity_id)}}">未填写,前去填写</a>
                                                @else
                                                    <a style="color:green;"
                                                       href="{{url('wechat/activity/show/'.$report->activities->type.'/'.$report->activity_id.'/report')}}">已填写，查看</a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        <a href="{{url('wechat/home/report-list')}}" class="feeds button adjust" >
                            查看更多
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{--我的测评报告end--}}

        {{--礼品券--}}
        <div class="column">
            <div class="ui segment mt8" style="margin-top: -1px;">
                <div class="ui feed">
                    <div class="event">
                        <div class="label" style="padding-top: 2px;">
                            <i class="ui black qrcode icon"></i>
                        </div>
                        <div class="content">
                            <div class="summary">
                                兑奖二维码
                            </div>
                        </div>
                        <a href="{{url('wechat/prize/prize_list')}}" class="feeds button adjust">
                            查看兑奖
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{--礼品券--}}
        <div class="column">
            <div class="ui segment mt8" style="margin-top: -1px;">
                <div class="ui feed">
                    <div class="event">
                        <div class="label" style="padding-top: 2px;">
                            <i class="ui red gift icon"></i>
                        </div>
                        <div class="content">
                            <div class="summary">
                                邮寄奖品
                            </div>
                        </div>
                        <a href="{{url('wechat/prize/showPostPrize')}}" class="feeds button adjust">
                            查看奖品
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{--查看帮助--}}
        <div class="column">
            <div class="ui segment mt8" style="margin-top: -1px;">
                <div class="ui feed">
                    <div class="event">
                        <div class="label" style="padding-top: 2px;">
                            <i class="ui green help circle icon"></i>
                        </div>
                        <div class="content">
                            <div class="summary">
                                帮助
                            </div>
                        </div>
                        <a href="{{url('wechat/help')}}" class="feeds button adjust">
                            查看帮助
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="m8">
    @include('wechat.layout.message')
    </div>

    <a href="{{url('wechat/apply')}}" id="user-submit" class="ui fluid green button absolute bottom">返回首页</a>

    @include('wechat.layout.level-explain')
    @include('wechat.layout.exp-explain')
    <div class="ui invite-friend modal">
        <div class="ui top attached grid columns" style="padding-bottom: 60px;">
            <div class="column p14" style="overflow: scroll;">
                <h3>邀请好友：</h3>
                <div class="content center-block text-center">
                    <div class="ui success message">您的邀请码是：<span class="green" id="clipTarget">{{$recommendCode}}</span>
                    </div>
                </div>
                <ol class="ui list">
                    <li>邀请你的好友关注博烟荟萃微信公众号</li>
                    <li>在“个人中心”中注册，并填写邀请码</li>
                    {{--<li>你和你的好友都将获得1张礼品券</li>--}}
                    <li>本活动最终解释权归博烟荟所有。</li>
                </ol>

            </div>
        </div>
        <button class="ui bottom attached fluid green button closeModal">返回</button>
    </div>
    </body>
@endsection