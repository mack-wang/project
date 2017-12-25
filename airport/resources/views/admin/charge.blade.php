@extends('admin.layout.frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">话费充值记录</div>
    <!--页面标题end-->


    <div class="ui one column grid m28">


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
                            <option value="phone">手机</option>
                            <option value="nickname">昵称</option>
                            <option value="shop_name">店铺</option>
                            <option value="status">状态</option>
                        </select>
                        <div id="search_charge" class="ui button">搜索</div>
                    </div>
                </div>
                <!--搜索文章end-->
            </div>
        </div>
        <!--筛选和搜索菜单end-->
        <!--搜索文章-->

        <a href="{{url('admin/charge/excel/')}}/{{ $key or '' }}/{{ $value or '' }}"
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
                            <label for="">用户</label>
                        </div>
                    </th>
                    <th>手机</th>
                    <th>终端</th>
                    <th>奖品</th>
                    <th>创建时间</th>
                    <th>订单号</th>
                    <th>充值金额</th>
                    <th>充值状态</th>
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
                                </label>
                            </div>
                        </td>
                        <td>{{$user->user_infos->phone}}</td>
                        <td>{{App\Models\Shop::find($user->users->shop_id)->name}}</td>
                        <td>{{$user->qrcode_prizes->name}}</td>
                        <td>{{$user->created_at}}</td>
                        <td>{{$user->result_charge_buys->serialno}}</td>
                        <td>{{round($user->result_charge_buys->price/1000,2)}}元</td>
                        <td>{{$user->result_charge_callbacks->status == 2? "充值成功":"充值失败" }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @if(isset($key))
                {{$users->appends([$key => $value])->links()}}
            @else
                {{$users->links()}}
            @endif
        </div>
        <!--所有文章end-->

        <div class="column">
            @include('admin.layout.message')
        </div>

        <div class="column">
            <div class="ui message info">
                <ul class="ui list">
                    <li>话费余额：{{$balance}}元</li>
                    <li>成功充值：{{$charged}}元</li>
                    <li>可以通过充值状态来查询，输入2查询充值成功，输入3查询充值失败</li>
                </ul>
            </div>
        </div>
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