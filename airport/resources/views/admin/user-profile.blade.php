@extends('admin.layout.frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">用户资料</div>
    <!--页面标题end-->
    <div class="ui container">
        <div class="ui two column  grid">
            <div class="six wide computer only column">
                <div class="ui card ">
                    <div class="image">
                        <img src="{{asset($user->user_wechats->headimgurl)}}">
                    </div>
                    <div class="content">
                        <a class="header">{{$user->user_wechats->nickname}}</a>
                        <div class="meta">
                            <span class="date">{{$user->created_at}}</span>
                        </div>
                        <div class="description">
                            @if($user->shops != null)
                                从 {{$user->shops->name}} 加入
                            @else
                                未绑定任何终端
                            @endif
                        </div>
                    </div>
                    <div class="extra content">
                        <div style="padding-top:8px;">
                            等级：
                            <div class="ui star rating" data-rating="{{$user->user_infos->level}}"
                                 data-max-rating="5"></div>
                        </div>
                        <div style="padding-top:8px;">
                            经验：{{$user->user_infos->exp}}
                        </div>
                        <div style="padding-top:8px;">
                            礼品券：{{$user->user_infos->ticket}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="ten wide computer only column">
                <table class="ui selectable celled table">
                    <thead>
                    <tr>
                        <th>项目</th>
                        <th>值</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="warning">真实姓名</td>
                        <td>{{$user->user_attrs->real_name}}</td>
                    </tr>
                    <tr>
                        <td class="warning">手机号</td>
                        <td>{{$user->user_infos->phone}}</td>
                    </tr>
                    <tr>
                        <td class="warning">身份证号</td>
                        <td>{{$user->user_attrs->id_card}}</td>
                    </tr>
                    <tr>
                        <td class="warning">年龄</td>
                        <td>{{$user->user_attrs->age}}</td>
                    </tr>
                    <tr>
                        <td class="warning">收入</td>
                        <td>{{$user->user_attrs->income}}</td>
                    </tr>
                    <tr>
                        <td class="warning">工作</td>
                        <td>{{$user->user_attrs->job}}</td>
                    </tr>
                    <tr>
                        <td class="warning">学历</td>
                        <td>{{$user->user_attrs->education}}</td>
                    </tr>
                    <tr>
                        <td class="warning">烟龄</td>
                        <td>{{$user->user_cigarettes->age}}</td>
                    </tr>
                    <tr>
                        <td class="warning">忠实品牌</td>
                        <td>{{$user->user_cigarettes->brand}}</td>
                    </tr>
                    <tr>
                        <td class="warning">期望品牌</td>
                        <td>{{$user->user_cigarettes->expect}}</td>
                    </tr>
                    <tr>
                        <td class="warning">城市</td>
                        <td>{{DB::table('mh_city')->find($user->user_addresses->city)->name}}</td>
                    </tr>
                    <tr>
                        <td class="warning">邮寄地址</td>
                        <td>{{DB::table('mh_city')->find($user->user_addresses->province)->name.DB::table('mh_city')->find($user->user_addresses->city)->name.DB::table('mh_city')->find($user->user_addresses->area)->name.$user->user_addresses->address}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        //启动dropdown
        $('.ui.dropdown').dropdown();

        //启动手风琴式菜单
        $('.ui.accordion').accordion();

        //启动标签式菜单
        $('.menu .item').tab();

        $('.ui.star.rating').rating('disable');

    </script>
    </body>
@endsection