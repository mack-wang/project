@extends('admin.layout.frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">所有用户</div>
    <!--页面标题end-->


    <div class="ui one column grid">

        <!--筛选和搜索菜单-->
        <div class="column">
            <div class="ui fluid two column grid">


                <!--搜索文章-->
                <div class="eight wide computer only sixteen wide tablet only mobile only column">
                    <form action="{{url('admin/user/search')}}" class="ui form" method="post">
                        <div class="ui action input">
                            <input type="text" name="value" placeholder="请输入">
                            <select class="ui selection dropdown" name="search" style="width: 200px">
                                <option value="name">昵称</option>
                                <option value="real_name">实名</option>
                                <option value="email">邮箱</option>
                                <option value="mail_phone">手机</option>
                                <option value="company">公司</option>
                            </select>
                            {{csrf_field()}}
                            <button id="search_user" class="ui submit button">搜索</button>
                        </div>
                    </form>
                </div>
                <!--搜索文章end-->
            </div>
        </div>

        <!--所有文章-->
        <div class="column">
            <table class="ui unstackable striped table">
                <thead>
                <tr>
                    <th>
                        <div class="ui checkbox">
                            <input type="checkbox" name="fun">
                            <label for="">用户</label>
                        </div>
                    </th>
                    <th>注册邮箱</th>
                    <th>公司</th>
                    <th>城市</th>
                    <th>手机</th>
                    <th>创建时间</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="ui checkbox">
                                <input type="checkbox" name="fun">
                                <label for="">
                                    <div class="ui list">
                                        <div class="item">
                                            <img class="ui tiny top aligned image"
                                                 @if($user->user_avatars != null)
                                                 src="{{asset($user->user_avatars->image_path)}}"
                                                 @else
                                                 src="{{asset('img/user.png')}}"
                                                 @endif
                                                 alt=""
                                                 style="width: 40px;height: 40px;"
                                            >
                                            <div class="content p0 mt4">
                                                <div>昵称：{{$user->name}}</a>
                                                    <div style="padding-top: 8px;">
                                                        实名：{{$user->user_addresses->real_name or '未填写'}}</div>
                                                </div>
                                            </div>
                                        </div>
                                </label>
                            </div>
                        </td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->user_companies->company or '/'}}</td>
                        <td>{{\App\Helper::getAddress($user->id)}}</td>
                        <td>{{$user->user_addresses->mail_phone or '/'}}</td>
                        <td>{{$user->created_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
        <!--所有文章end-->
    </div>

    <script>
        //启动dropdown
        $('.ui.dropdown').dropdown();

        //启动手风琴式菜单
        $('.ui.accordion').accordion();

        //启动标签式菜单
        $('.menu .item').tab();

    </script>
    </body>
@endsection