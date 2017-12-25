@extends('admin.layout.frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">终端管理员</div>
    <!--页面标题end-->


    <div class="ui one column grid m28">


        <!--筛选和搜索菜单-->
        <div class="column">
            <div class="ui fluid two column grid">


                <!--目录筛选-->
                <div class="four wide computer only sixteen wide tablet only mobile only column"
                     style="padding-left: 0;">
                    <div class="ui two item fluid menu clear-shadow">
                        <div class="ui dropdown link item">
                            <span class="text">
                               @if(isset($key) && $key == 'area_id')
                                    {{$areas->where('id', $value)->pluck('area')[0]}}
                                @else
                                    所在地区
                                @endif
                            </span>
                            <i class="dropdown icon"></i>
                            <div class="menu text-center">
                                @foreach($areas as $area)
                                    <a class="text-center item"
                                       href="{{ url('admin/manager/search/area_id').'/'.$area->id }}">
                                        {{ $area->area }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="ui dropdown link item">
                            <span class="text">{{session('page')?'每页'.session('page').'条':'每页条数'}}</span>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <a class="text-center item" href="{{ url('admin/shop/setPage').'/5' }}">
                                    5条
                                </a>
                                <a class="text-center item" href="{{ url('admin/shop/setPage').'/10' }}">
                                    10条
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--目录筛选end-->


                <!--搜索文章-->
                <div class="eight wide computer only sixteen wide tablet only mobile only column">
                    <div class="ui action input">
                        <input type="text" name="search" placeholder="请输入">
                        <select class="ui compact selection dropdown">
                            <option selected="" value="manager_name">名字</option>
                            <option value="name">店铺</option>
                            <option value="nickname">昵称</option>
                            <option value="phone">手机</option>
                        </select>
                        <div id="search_manager" class="ui button">搜索</div>
                    </div>
                </div>
                <!--搜索文章end-->
            </div>
        </div>
        <!--筛选和搜索菜单end-->
        <!--搜索文章-->

        <a href="{{url('admin/manager/excel/')}}/{{ $key or '' }}/{{ $value or '' }}"
           class="ui green button ml14">导出Excel表格</a>

        <!--搜索文章end-->
        <!--所有文章-->
        <div class="column">
            <table class="ui unstackable striped table">
                <thead>
                <tr>
                    <th>
                        <div class="ui checkbox">
                            <input type="checkbox" name="fun">
                            <label for="">终端管理员</label>
                        </div>
                    </th>
                    <th>手机</th>
                    <th>终端</th>
                    <th>地区</th>
                    <th>权限</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($managers as $manager)
                    <tr>
                        <td>
                            <div class="ui checkbox">
                                <input type="checkbox" name="fun">
                                <label for="">
                                    <div class="ui list">
                                        <div class="item">
                                            <img class="ui tiny top aligned image"
                                                 src="{{asset($manager->user_wechats->headimgurl)}}"
                                                 alt=""
                                                 style="width: 40px;height: 40px;"
                                            >
                                            <div class="content">
                                                <a href="{{url('admin/user/profile').'/'.$manager->user_id}}" >{{$manager->manager_name}}</a>
                                                <div style="padding-top: 8px;">昵称：{{$manager->user_wechats->nickname}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </td>
                        <td>{{$manager->phone}}</td>
                        <td><a href="{{url('admin/shop/profile/').'/'.$manager->shop_id}}">
                                {{$manager->shops->name}}
                            </a></td>
                        <td>{{$areas->where('id', $manager->shops->area_id)->pluck('area')[0]}}</td>
                        <td>@if($manager->phone == $manager->shops->phone)<i class="yu-user"></i>负责人@endif</td>
                        <td>{{$manager->created_at}}</td>
                        <td><a class="delete-button" onclick="return confirm('确定拉黑？')"
                               href="{{url('admin/manager/remove').'/'.($manager->id)}}">拉黑</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(isset($key))
                {{$managers->appends([$key => $value])->links()}}
            @else
                {{$managers->links()}}
            @endif
        </div>
        <!--所有文章end-->

        <!--批量操作-->
        <div class="eight wide computer only sixteen wide tablet only mobile only column pb100">
            <form action="{{url('admin/manager/white')}}" method="get">
                <div class="ui action input">
                    <input type="text" name="phone" placeholder="请输入被拉黑的手机号">
                    <button class="ui submit button">取消拉黑</button>
                </div>
            </form>
            @if(session('success'))
                <div class="ui success message visible">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="ui error message visible">{{ session('error') }}</div>
            @endif
            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <div class="ui error message visible">{{ $error }}</div>
                @endforeach
            @endif
        </div>
        <!--批量操作end-->
    </div>

    <div id="key-value" data-key="{{ $key or '' }}" data-value="{{ $value or '' }}"></div>
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