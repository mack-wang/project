@extends('admin.layout.editor-frame')
@section('content')
    <body style="overflow: auto;">
    <!--页面标题-->
    <div class="ui header m8    ">轮播图管理</div>
    <!--页面标题end-->
    <div class="ui one column grid m28">
        <!--活动轮播图模块-->

        <div class="four wide computer sixteen wide mobile column">
            <div class="ui top attached header">
                活动首页图
            </div>
            <div class="ui bottom  attached segment">
                <div id="headimg_box" class="ui one special cards headimg_box" data-limit="1">
                </div>
                <div class="ui hidden divider"></div>
                <div id="headimg_add" class="ui big basic icon button">
                    <i class="ui icon add"></i>
                </div>
            </div>
        </div>
    </div>
    </body>
@endsection