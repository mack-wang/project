@extends('admin.layout.editor-frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui grid pb100">


        <!--添加文章属性-->

        <div class="four wide computer sixteen wide mobile column">
            <form id="prizeForm" action="{{url('admin/prize/form')}}" class="ui form" method="post">
                <!--任务简称-->
                <div class="ui top attached header">
                    奖品图片
                </div>
                <div class="ui bottom attached segment">
                    <div id="imageBox" class="ui one special cards headimg_box" data-limit="1">
                    </div>
                    <div class="ui hidden divider"></div>
                    <div id="imageAdd" class="ui big basic icon button">
                        <i class="ui icon add"></i>
                    </div>
                    {{--隐藏ueditor的视图，仅用于调用和实例化--}}
                    <div style="display: none;">
                        <script id="uploadImage" type="text/plain"></script>
                    </div>
                </div>




                <div class="ui top attached header">
                    奖品名字
                </div>
                <div class="ui bottom  attached segment">
                    <div class="field">
                        <input type="text" name="name" placeholder="奖品名字">
                    </div>
                </div>

                <div class="ui top attached header">
                    奖品类型（填0或1，0为兑换 1为抽奖）
                </div>
                <div class="ui bottom  attached segment">
                    <div class="field">
                        <input type="text" name="type" placeholder="奖品类型">
                    </div>
                </div>

                <div class="ui top attached header">
                    奖品数量
                </div>
                <div class="ui bottom  attached segment">
                    <div class="field">
                        <input type="text" name="count" placeholder="奖品数量">
                    </div>
                </div>

                <div class="ui top attached header">
                    需要消耗的礼品券数量
                </div>
                <div class="ui bottom  attached segment">
                    <div class="field">
                        <input type="text" name="cost" placeholder="需要消耗的礼品券数量">
                    </div>
                </div>

                <div class="ui top attached header">
                    有效期（单位秒，86400秒=1天）
                </div>
                <div class="ui bottom  attached segment">
                    <div class="field">
                        <input type="text" name="expire" placeholder="二维码有效期">
                    </div>
                </div>



                <button id="prizeSubmit" class="ui fluid green button submit" style="margin-top: 20px;">提交</button>
                <div class="ui error message"></div>
                @include("admin.layout.message")
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <input type="hidden" name="image_path" placeholder="奖品图片">
            </form>
        </div>


        <div class="twelve wide computer sixteen wide mobile column">
            <table class="ui unstackable striped table" id="shop-table">
                <thead>
                <tr>
                    <th>奖品图片</th>
                    <th>名字</th>
                    <th>数量</th>
                    <th>礼品券</th>
                    <th>奖品类型</th>
                    <th>有效期</th>
                    <th>已兑换</th>
                    <th>状态</th>
                    <th>更新日期</th>
                    <th>编辑</th>
                    <th>删除</th>
                </tr>
                </thead>
                <tbody>
                @foreach($prizes as $item)
                    <tr>
                        <td data-value="{{$item->image_path}}">
                            <img class="ui mini image" src="{{asset($item->image_path)}}" alt="">
                        </td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->count}}</td>
                        <td>{{$item->cost}}</td>
                        <td>{{$item->type ? "抽奖":"兑换"}}</td>
                        <td>{{($item->expire)."秒"}}</td>
                        <td>{{\App\Models\Qrcodes::where('prize_id',$item->id)->count()}}</td>
                        <td>
                            @if(!$item->off)
                                <div class="ui fitted toggle checkbox prize">
                                    <input type="checkbox" checked="checked" value="{{$item->id}}">
                                    <label></label>
                                </div>
                            @else
                                <div class="ui fitted toggle checkbox prize">
                                    <input type="checkbox" value="{{$item->id}}">
                                    <label></label>
                                </div>
                            @endif
                        </td>
                        <td>{{ date("Y-m-d",strtotime($item->updated_at)) }}</td>
                        <td><a class="prizeEdit" data-value="{{$item->id}}">编辑</a>
                        </td>
                        <td><a onclick="return confirm('是否确定删除？')"
                               href="{{url('admin/prize/delete/'.$item->id)}}">删除</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$prizes->links()}}
        </div>

    </div>
    <!--页面标题end-->

    </body>
@endsection