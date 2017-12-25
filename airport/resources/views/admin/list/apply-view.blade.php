@extends('admin.layout.frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">查看活动详情</div>
    <!--页面标题end-->

    <div class="ui one column grid m28">
        <div class="column">
            <div class="ui header">{{$activity->activity_attrs->title}}</div>
            <div class="ui ordered steps">
                @if($activity->type == "apply")
                    <div class="active step">
                        <div class="content">
                            <div class="title">试用申请</div>
                            <div class="description">活动正在开展</div>
                        </div>
                    </div>
                    <div class="active step">
                        <div class="content">
                            <div class="title">后台筛选</div>
                            <div class="description">当前需要筛选试用者</div>
                        </div>
                    </div>
                @else
                    <div class="active step">
                        <div class="content">
                            <div class="title">限时秒杀</div>
                            <div class="description">活动正在开展</div>
                        </div>
                    </div>
                    <div class="active step">
                        <div class="content">
                            <div class="title">先抢先得</div>
                            <div class="description">自动进行</div>
                        </div>
                    </div>
                @endif
                <div class="active step">
                    <div class="content">
                        <div class="title">邮寄产品</div>
                        <div class="description">请及时邮寄试用产品</div>
                    </div>
                </div>
                <div class="active step">
                    <div class="content">
                        <div class="title">试用评价</div>
                        <div class="description">试用评价进行中</div>
                    </div>
                </div>
            </div>


        </div>

        <!--筛选和搜索菜单-->
        <div class="column">
            <div class="ui fluid two column grid">


                <!--目录筛选-->
                <div class="four wide computer only sixteen wide tablet only mobile only column"
                     style="padding-left: 0;">
                    <div class="ui one item fluid menu clear-shadow">
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
                        <select class="ui selection dropdown" style="width: 200px">
                            <option value="real_name">名字</option>
                            <option value="nickname">昵称</option>
                            <option value="phone">手机</option>
                            <option value="shop_name">店铺</option>
                        </select>
                        <div id="search_applyView" data-value="{{$activity->id}}" class="ui button">搜索</div>
                    </div>
                </div>
                <!--搜索文章end-->
            </div>
        </div>
        <!--筛选和搜索菜单end-->
        <!--搜索文章-->

        <a href="{{url('admin/list/view/excel/')}}/{{ $activity->id or '' }}/{{ $key or '' }}/{{ $value or '' }}"
           class="ui green button ml14">导出Excel表格</a>
        @if($activity->elect == 1)
        <a href="{{url('admin/list/view/setElect/'.$activity->id)}}" onclick="return confirm('是否确定要结束筛选，并给选中者发送短信通知？确定后，不可更改结果')" class="ui green button ml14">人工筛选完成</a>
        @endif



        <!--搜索文章end-->
        <!--所有文章-->
        <div class="column">
            <table class="ui unstackable striped table">
                <thead>
                <tr>
                    <th>用户</th>
                    <th>手机</th>
                    <th>终端</th>
                    <th>省份</th>
                    <th>城市</th>
                    <th>县区</th>
                    <th>具体地址</th>
                    <th>创建时间</th>
                    <th>试用评价</th>
                    <th>同意申请</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="ui list">
                                <div class="item">
                                    <img class="ui tiny top aligned image"
                                         src="{{asset($user->user_wechats->headimgurl)}}"
                                         alt=""
                                         style="width: 40px;height: 40px;"
                                    >
                                    <div class="content">
                                        <a href="{{url('admin/user/profile').'/'.$user->users->id}}">{{$user->user_attrs->real_name}}</a>
                                        <div style="padding-top: 8px;">
                                            昵称：{{$user->user_wechats->nickname}}</div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{$user->user_infos->phone}}</td>
                        <td>{{App\Models\Shop::find($user->users->shop_id)->name}}</td>
                        <td>{{DB::table('mh_city')->find($user->user_addresses->province)->name}}</td>
                        <td>{{DB::table('mh_city')->find($user->user_addresses->city)->name}}</td>
                        <td>{{DB::table('mh_city')->find($user->user_addresses->area)->name}}</td>
                        <td>{{$user->user_addresses->address}}</td>
                        <td>{{$user->created_at}}</td>
                        <td>
                            @if($user->reports==null)
                                未填写
                            @else
                                <a href="{{url('admin/list/view/showReport/'.$user->reports->id)}}">已填写</a>
                            @endif
                        </td>
                        <td>@if(strtotime($user->activities->end_at) > time())
                                活动未结束
                            @elseif($user->status == 1)
                                申请成功
                            @elseif($activity->elect == 0)
                                自动选择
                            @elseif($activity->elect == 1 && $user->status != 1)
                                <div class="ui fitted checkbox applyView">
                                    <input type="checkbox" value="{{$user->id}}">
                                </div>
                            @elseif($activity->elect == 1 && $user->status == 1)
                                <div class="ui fitted checkbox applyView">
                                    <input type="checkbox" checked="checked" value="{{$user->id}}">
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="ui success message">
                申请人数:{{$results['userCount'] or 0}}人 |
                申请成功人数:{{$results['winnerCount'] or 0}}人 |
                已填写试用评价人数:{{$results['reportCount'] or 0}}人<br>
                奖品：{{$activity->fetch_cigarettes->name}} | 数量：{{$activity->activity_prizes->count}} |
                开始时间：{{$activity->start_at}} | 结束时间:{{$activity->end_at}}
            </div>
            @if(isset($key))
                {{$users->appends([$key => $value])->links()}}
            @else
                {{$users->links()}}
            @endif
        </div>
        <!--所有文章end-->

        <!--批量操作-->
        <div class="eight wide computer only sixteen wide tablet only mobile only column pb100">
            @include('admin.layout.message')
        </div>
        <!--批量操作end-->
    </div>
    <div id="key-value" data-key="{{ $key or '' }}" data-value="{{ $value or '' }}"></div>

    </body>
    <script>
        //启动dropdown
        $('.ui.dropdown').dropdown();

        //启动手风琴式菜单
        $('.ui.accordion').accordion();

        //启动标签式菜单
        $('.menu .item').tab();
        var completed ={{$step}};
        if (completed >= 0) {
            $(".step:lt(" + completed + ")").removeClass('active').addClass('completed');
        }
    </script>
@endsection