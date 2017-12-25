@extends('admin.layout.editor-frame')
@section('content')
    <body class="iframe-body" style="overflow: auto;">
    <!--页面标题-->
    <div class="ui header m8">编辑热线</div>
    <!--页面标题end-->

    <div class="ui one column grid pb100" style="margin-left: 2px;">
        <!--添加文章属性-->

        <div class="column">
            <form id="connectForm" action="{{url('admin/connect/update')}}" class="ui form" method="post">
                <div class="field">
                    <label for="">联系图片</label>
                    <div class="ui segment clear-shadow">
                        <div id="imageBox" class="ui one special cards headimg_box" data-limit="1" style="width: 30%;">
                            <div class="card">
                                <div class="blurring dimmable image">
                                    <div class="ui dimmer">
                                        <div class="content">
                                            <div class="center">
                                                <div class="ui inverted button delete">删除</div>
                                            </div>
                                        </div>
                                    </div>
                                    <img data-value="{{$contact->image}}" src="{{asset($contact->image)}}">
                                </div>
                            </div>
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
                </div>


                <div class="two fields">
                    <div class="field">
                        <label for="">服务热线电话（默认拨打）</label>
                        <input type="text" name="phone" placeholder="输入电话号码" value="{{$contact->phone}}">
                    </div>
                    <div class="field">
                        <label for="">服务热线电话2</label>
                        <input type="text" name="time" placeholder="输入服务时间" value="{{$contact->time}}">
                    </div>
                </div>
                <div class="field">
                    <label for="">服务热线说明</label>
                    <input type="text" name="content" placeholder="输入说明内容" value="{{$contact->content}}">
                </div>

                <!--任务简称-->


                <button id="connectSubmit" class="ui blue button submit" style="margin-top: 20px;">修改</button>
                <div class="ui error message"></div>
                @include("admin.layout.message")
                {{ csrf_field() }}
                <input type="hidden" name="image" placeholder="联系图片" value="{{$contact->image}}">
            </form>
        </div>

    </div>
    <!--页面标题end-->


    </body>
    <script>
        $('#imageBox').find('.image').dimmer({
            on: 'hover'
        });
        $('#imageBox').find('.delete').click(function () {
            $(this).closest('.card').remove();
        });
    </script>
@endsection