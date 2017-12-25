@extends('admin.layout.frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">所有终端</div>
    <!--页面标题end-->


    <div class="ui one column grid m28">


        <!--筛选和搜索菜单-->
        <div class="column">
            <div class="ui fluid four column grid">


                <!--目录筛选-->
                <div class="four wide computer only sixteen wide tablet only mobile only column">
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
                                       href="{{ url('admin/shop/search/area_id').'/'.$area->id }}">
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

                <!--可见筛选-->
                <div  class="six wide computer only sixteen wide tablet only mobile only column">
                    <div id="shop-type" class="ui fluid basic buttons">
                        <a href="{{url('admin/shop')}}" class="ui button">
                            全部
                        </a>
                        <a id="test1" href="{{url('admin/shop/search/type/A')}}" class="ui button">
                            A类户
                        </a>
                        <a href="{{url('admin/shop/search/type/B')}}" class="ui button">
                            B类户
                        </a>
                        <a href="{{url('admin/shop/search/type/C')}}" class="ui button">
                            C类户
                        </a>
                    </div>
                </div>
                <!--可见筛选end-->

                <!--搜索文章-->
                <div class="six wide computer only sixteen wide tablet only mobile only column">
                    <div class="ui action input">
                        <input type="text" name="search" placeholder="请输入">
                        <select class="ui compact selection dropdown">
                            <option selected="" value="name">店铺</option>
                            <option value="phone">手机</option>
                            <option value="cigarette_id">证号</option>
                        </select>
                        <div id="search_shop" class="ui button">搜索</div>
                    </div>
                </div>
                <!--搜索文章end-->
            </div>
        </div>
        <!--筛选和搜索菜单end-->
        <!--搜索文章-->

        <a id="test2" href="{{url('admin/shop/excel/')}}/{{ $key or '' }}/{{ $value or '' }}"
           class="ui green button ml20">导出Excel表格</a>

        <form action="{{url('admin/shop/set/area')}}" method="GET">
        <div class="ui labeled input">
            <div class="ui label submit button area">
                确定
            </div>
            <input type="text" name="area" placeholder="添加地区">
        </div>
        </form>

        <!--搜索文章end-->
        <!--所有文章-->
        <div class="column">
            <table class="ui unstackable striped table" id="shop-table">
                <thead>
                <tr>
                    <th>
                        <div class="ui checkbox">
                            <input type="checkbox">
                            <label for="">终端</label>
                        </div>
                    </th>
                    <th>地区</th>
                    <th>手机号</th>
                    <th>烟草证号</th>
                    <th>类型</th>
                    <th>等级</th>
                    <th>黑名单</th>
                    <th>积分</th>
                    <th>日期</th>
                    <th>编辑</th>
                    <th>删除</th>
                </tr>
                </thead>
                <tbody>
                @foreach($shops as $shop)
                    <tr>
                        <td>
                            <div class="ui shop checkbox">
                                <input type="checkbox" class="shop_id" value="{{$shop->id}}">
                                <label for="">
                                    <a class="shopname" href="{{url('admin/shop/profile/').'/'.$shop->id}}">
                                        {{$shop->name}}
                                    </a>
                                </label>
                            </div>
                        </td>
                        <td data-value="{{$shop->shop_areas->id}}">{{$shop->shop_areas->area}}</td>
                        <td>{{$shop->phone}}</td>
                        <td>{{$shop->cigarette_id}}</td>
                        <td>{{$shop->shop_attrs->type}}</td>
                        <td>{{($shop->shop_attrs->level).'星'}}</td>
                        <td data-value="{{$shop->shop_attrs->black}}">@if($shop->shop_attrs->black == 1)是@endif</td>
                        <td>{{$shop->shop_attrs->scores}}</td>
                        <td>{{ date("Y-m-d",strtotime($shop->created_at)) }}</td>
                        <td><a class="edit-button" href="">编辑</a></td>
                        <td><a class="delete-button" onclick="return confirm('是否确定删除？')"
                               href="{{url('admin/shop/remove').'/'.($shop->id)}}">删除</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(isset($key))
                {{$shops->appends([$key => $value])->links()}}
            @else
                {{$shops->links()}}
            @endif
        </div>
        <!--所有文章end-->

        <!--批量操作-->
        <div class="eight wide computer only sixteen wide tablet only mobile only column">
            <div class="ui buttons">
                <div class="ui button p14">批量操作</div>
                <div class="ui floating dropdown icon button">
                    <i class="dropdown icon"></i>
                    <div id="checked" class="menu">
                        <div data-value="delete" class="item"><i class="delete icon"></i> 删除选中</div>
                        <div data-value="black" class="item"><i class="toggle on icon"></i> 进黑名单</div>
                        <div data-value="white" class="item"><i class="toggle off icon"></i> 进白名单</div>
                    </div>
                </div>
            </div>
            <div id="add-shop" class="ui primary large button ml20">
                添加店铺
            </div>
            <div id="add-shop-excel" class="ui primary basic large button ml20">
                上传店铺表格
            </div>
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
    <div class="ui modal add-shop visible">
        <i class="close icon"></i>
        <div class="header">
            添加店铺
        </div>
        <div class="content">
            <form action="{{url('admin/shop')}}" method="post" class="ui form add-shop">
                <div class="required field">
                    <label>店铺名</label>
                    <input type="text" name="name" value="{{old('name')}}">
                </div>
                <div class="four fields">
                    <div class="required field">
                        <label>所在地区</label>
                        <select class="ui search dropdown" name="area_id">
                            @if(old('area_id'))
                                <option selected value="{{old('area_id')}}">
                                    {{$areas->where('id', old('area_id'))->pluck('area')[0]}}
                                </option>
                            @endif
                            @foreach($areas as $area)
                                <option value="{{$area->id}}">{{$area->area}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="required field">
                        <label>店铺类型</label>
                        <select class="ui search dropdown" name="type">
                            @if(old('type'))
                                <option selected value="{{old('type')}}">{{old('type')}}</option>
                            @endif
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                    <div class="required field">
                        <label>店主手机号</label>
                        <div class="ui icon input">
                            <input type="text" name="phone" value="{{old('phone')}}">
                            <i class="phone icon"></i>
                        </div>
                    </div>
                    <div class="required field">
                        <label>烟草证号</label>
                        <div class="ui icon input">
                            <input type="text" name="cigarette_id" value="{{old('cigarette_id')}}">
                            <i class="yu-id-card icon"></i>
                        </div>
                    </div>
                </div>
                <div class="four fields">
                    <div class="field">
                        <label>店铺等级</label>
                        <input type="text" name="level" value="{{old('level')}}">
                    </div>
                    <div class="field">
                        <label>店铺积分</label>
                        <input type="text" name="scores" value="{{old('scores')}}">
                    </div>
                    <div class="field">
                        <label>店铺终端类型</label>
                        <select class="ui search dropdown" name="shopType">
                            @if(old('black')==1)
                                <option selected value="{{old('black')}}">{{$black or ''}}</option>
                            @endif
                            <option value="shop">烟店</option>
                            <option value="airport">机场</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>黑名单</label>
                        <select class="ui search dropdown" name="black">
                            @if(old('black')==1)
                                <option selected value="{{old('black')}}">{{$black or ''}}</option>
                            @endif
                            <option value="0">未列入</option>
                            <option value="1">已列入</option>
                        </select>
                    </div>
                </div>
                {{csrf_field()}}
                <input type="hidden" name="_method" value="POST">
                <div class="ui error message"></div>
            </form>
        </div>
        <div class="actions">
            <div class="ui gray button reset">
                重置
            </div>
            <div class="ui black deny button">
                取消
            </div>
            <div id="test3" class="ui positive button">
                上传
            </div>
        </div>
    </div>

    <div class="ui modal add-shop-excel visible">
        <i class="close icon"></i>
        <div class="header">
            上传店铺表格
        </div>
        <div class="content">
            <form class="add-shop-excel" action="{{url('admin/shop/storeExcel')}}" method="POST"
                  enctype="multipart/form-data">
                <a class="ui basic primary button"
                   href="{{url('admin/resource/excel/shops_template')}}">下载店铺模板表格</a>
                {{csrf_field()}}
                <div class="ui center aligned segment pv50">
                    <div class="ui disabled lighter header"><i class="upload icon"></i></div>
                    <div class="ui primary button shops_template">
                        <span>上传店铺表格</span> <i class="yu-angle-right icon"></i>
                    </div>
                    <input type="file" name="excel" style="display: none;">
                </div>
            </form>
        </div>
        <div class="actions">
            <div class="ui black deny button">
                取消
            </div>
            <div class="ui positive button">
                上传
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

        $('.area.button').click(function () {
            $(this).parent().parent().submit();
        })
    </script>
    </body>
@endsection