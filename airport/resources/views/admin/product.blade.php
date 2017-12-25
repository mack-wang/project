@extends('admin.layout.editor-frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui grid pb100">


        <!--添加文章属性-->

        <div class="four wide computer sixteen wide mobile column">
            <form id="productForm" action="{{url('admin/product/form')}}" class="ui form" method="post">
                <!--任务简称-->
                <div class="ui top attached header">
                    产品图片(推荐150px*240px)
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
                    产品类型（0为烟 1为非烟）
                </div>
                <div class="ui bottom  attached segment">
                    <div class="field">
                        <input type="text" name="status" placeholder="产品类型">
                    </div>
                </div>

                <div class="ui top attached header">
                    产品信息
                </div>
                <div class="ui bottom  attached segment">
                    <div class="field">
                        <input type="text" name="name" placeholder="产品名字">
                    </div>
                    <div class="field">
                        <input type="text" name="brand" placeholder="品牌（若填下一项，此项不填）">
                    </div>
                    <div class="field">
                        <div id="productSearch" class="ui fluid search">
                            <div class="ui fluid  icon input">
                                <input id="productSearch" class="prompt" type="text" placeholder="从已有的品牌中选择">
                                <i class="search icon"></i>
                            </div>
                            <div class="results"></div>
                        </div>
                    </div>
                    <div class="field">
                        <input type="text" name="price" placeholder="价格">
                    </div>
                </div>

                <div class="ui top attached header">
                    卷烟信息（卷烟必填，非烟不填）
                </div>
                <div class="ui bottom  attached segment">
                    <div class="field">
                        <input type="text" name="packet_code" placeholder="包烟条形码">
                    </div>
                    <div class="field">
                        <input type="text" name="carton_code" placeholder="条烟条形码">
                    </div>
                    <div class="field">
                        <input type="text" name="type" placeholder="卷烟类型（如烤烟型）">
                    </div>
                    <div class="field">
                        <input type="text" name="size" placeholder="卷烟尺寸">
                    </div>
                    <div class="field">
                        <input type="text" name="company" placeholder="产品生产公司">
                    </div>
                </div>


                <button id="productSubmit" class="ui fluid green button submit" style="margin-top: 20px;">提交</button>
                <div class="ui error message"></div>
                @include("admin.layout.message")
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <input type="hidden" name="image_url" placeholder="产品图片">
                <input type="hidden" name="brand_id" placeholder="产品品牌ID">
            </form>
        </div>


        <div class="twelve wide computer sixteen wide mobile column">
            <form action="{{url('admin/product/search/')}}" method="get">
                <div class="ui action input">
                    <input type="text" name="title" placeholder="搜索产品" value="">
                    <button class="ui icon button search">
                        <i class="search icon"></i>
                    </button>
                </div>
            </form>
            <table class="ui unstackable striped table" id="shop-table">
                <thead>
                <tr>
                    <th>产品图片</th>
                    <th>名字</th>
                    <th>品牌</th>
                    <th>包烟条码</th>
                    <th>条烟条码</th>
                    <th>卷烟类型</th>
                    <th>卷烟尺寸</th>
                    <th>卷烟价格</th>
                    <th>生产公司</th>
                    <th>编辑</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $item)
                    <tr>
                        <td data-value="{{$item->image_url}}">
                            <img class="ui mini image" src="{{asset($item->image_url)}}" alt="">
                        </td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->brand}}</td>
                        <td>{{$item->packet_code}}</td>
                        <td>{{$item->carton_code}}</td>
                        <td>{{$item->type}}</td>
                        <td>{{$item->size}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->company}}</td>
                        <td><a class="productEdit" data-value="{{$item->id}}">编辑</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(isset($title))
                {{$products->appends(['title' => $title])->links()}}
            @else
                {{$products->links()}}
            @endif

        </div>

    </div>
    <!--页面标题end-->

    </body>
@endsection