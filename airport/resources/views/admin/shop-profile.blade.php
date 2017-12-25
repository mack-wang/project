@extends('admin.layout.frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">终端资料</div>
    <!--页面标题end-->
    <div class="ui container">
        <div class="ui two column  grid">
            <div class="six wide computer only column">
                <div class="ui card ">
                    <div class="image">
                        <img src="{{$qrcode_image}}">
                    </div>
                    <div class="content">
                        <a class="header">{{$shop->name}}</a>
                        <div class="meta">
                            <span class="date">{{$shop->created_at}}</span>
                        </div>
                        <div class="description">
                            管理员共 {{$shop->shop_managers->count()}} 名
                        </div>
                    </div>
                    <div class="extra content">
                        <div style="padding-top:8px;">
                            等级：
                            <div class="ui star rating" data-rating="{{$shop->shop_attrs->level}}"
                                 data-max-rating="5"></div>
                        </div>
                        <div style="padding-top:8px;">
                            积分：{{$shop->shop_attrs->scores}}
                        </div>
                        <div style="padding-top:8px;">
                            状态：@if($shop->shop_attrs->black == 1)在黑名单中@else正常@endif
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
                        <td class="warning">终端名</td>
                        <td>{{$shop->name}}</td>
                    </tr>
                    <tr>
                        <td class="warning">负责人</td>
                        <td>
                            @foreach($shop->shop_managers as $manager)
                                @if($manager->phone == $shop->phone)
                                    <a href="{{url('admin/user/profile/').'/'.$manager->user_id}}">{{$manager->manager_name}}</a>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="warning">负责人手机号</td>
                        <td>{{$shop->phone}}</td>
                    </tr>
                    <tr>
                        <td class="warning">烟草证号</td>
                        <td>{{$shop->cigarette_id}}</td>
                    </tr>
                    <tr>
                        <td class="warning">地区</td>
                        <td>{{$areas->where('id', $shop->area_id)->pluck('area')[0]}}</td>
                    </tr>
                    <tr>
                        <td class="warning">用户人数</td>
                        <td>{{$shop->users->count()}}</td>
                    </tr>
                    <tr>
                        <td class="warning">管理员人数</td>
                        <td>{{$shop->shop_managers->count()}}</td>
                    </tr>
                    <tr>
                        <td class="warning">管理员</td>
                        <td>
                            @foreach($shop->shop_managers as $manager)
                                <a href="{{url('admin/user/profile/').'/'.$manager->user_id}}">{{$manager->manager_name}}
                                    、</a>
                            @endforeach
                        </td>
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