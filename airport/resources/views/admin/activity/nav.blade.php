@extends('admin.layout.editor-frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui grid pb100">


        <!--添加文章属性-->

        <div class="four wide computer sixteen wide mobile column">
            <form id="navForm" action="{{url('admin/activity/nav')}}" class="ui form" method="post">
                <!--任务简称-->
                <div class="ui top attached header">
                    导航图
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


                @include('admin.layout.article')


                <div class="ui top attached header">
                    链接
                </div>
                <div class="ui bottom  attached segment">
                    <div class="field">
                        <input type="text" name="redirect_path" placeholder="链接示例 /wechat/apply">
                    </div>
                </div>

                <div class="ui info message">
                    文章和链接只需要填写一个，若同时填写，则以链接为准。
                </div>


                <button id="navSubmit" class="ui fluid green button submit" style="margin-top: 20px;">提交</button>
                <div class="ui error message"></div>
                @include("admin.layout.message")
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <input type="hidden" name="image_path" placeholder="导航图">
            </form>
        </div>


        <div class="twelve wide computer sixteen wide mobile column">
            <table class="ui unstackable striped table" id="shop-table">
                <thead>
                <tr>
                    <th>导航图</th>
                    <th>文章</th>
                    <th>跳转路径</th>
                    <th>状态</th>
                    <th>更新日期</th>
                    <th>编辑</th>
                    <th>删除</th>
                </tr>
                </thead>
                <tbody>
                @foreach($navs as $nav)
                    <tr>
                        <td data-value="{{$nav->image_path}}">
                            <img class="ui small image" src="{{asset($nav->image_path)}}" alt="">
                        </td>
                        <td>{{$nav->articles->title or "无"}}</td>
                        <td>{{$nav->redirect_path or "无" }}</td>
                        <td>
                            @if($nav->state === 1)
                                <div class="ui fitted toggle checkbox nav">
                                    <input type="checkbox" checked="checked" value="{{$nav->id}}">
                                    <label></label>
                                </div>
                            @else
                                <div class="ui fitted toggle checkbox nav">
                                    <input type="checkbox" value="{{$nav->id}}">
                                    <label></label>
                                </div>
                            @endif
                        </td>
                        <td>{{ date("Y-m-d",strtotime($nav->created_at)) }}</td>
                        <td><a class="navEdit" data-value="{{$nav->id}}" data-title="{{$nav->articles->title or "无"}}">编辑</a>
                        </td>
                        <td><a onclick="return confirm('是否确定删除？')"
                               href="{{url('admin/activity/nav/delete/'.$nav->id)}}">删除</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$navs->links()}}
        </div>

    </div>
    <!--页面标题end-->

    </body>
@endsection