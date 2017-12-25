@extends('admin.layout.editor-frame')
@section('content')
    <body class="iframe-body" style="overflow: auto;">
    <!--页面标题-->
    <div class="ui header m8">编辑导航图</div>
    <!--页面标题end-->

    <div class="ui one column grid pb100" style="margin-left: 2px;">
        <!--添加文章属性-->


        <div class="column">
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
                            <img class="ui tiny image" src="{{asset($nav->image_path)}}" alt="">
                        </td>
                        <td>{{$nav->articles->title or "无"}}</td>
                        <td>{{$nav->redirect_path or "无" }}</td>
                        <td>
                            <div class="ui fitted toggle checkbox nav">
                                <input type="checkbox" {{$nav->state ? "checked" : ""}} checked="checked"
                                       value="{{$nav->id}}">
                                <label></label>
                            </div>
                        </td>
                        <td>{{ date("Y-m-d",strtotime($nav->created_at)) }}</td>
                        <td><a class="navEdit" data-value="{{$nav->id}}"
                               data-title="{{$nav->articles->title or "无"}}">编辑</a>
                        </td>
                        <td><a onclick="return confirm('是否确定删除？')"
                               href="{{url('admin/index/nav/delete/'.$nav->id)}}">删除</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$navs->links()}}
        </div>

        <div class="column">
            <form id="navForm" action="{{url('admin/index/nav/form')}}" class="ui form" method="post">


                <div class="two fields">
                    <div class="field">
                        <label for="">文章</label>
                        <div id="articleSearch" class="ui fluid search article">
                            <div class="ui fluid  icon input">
                                <input id="articleTitle" class="prompt" type="text" placeholder="选择文章">
                                <i class="search icon"></i>
                            </div>
                            <div class="results"></div>
                        </div>
                    </div>
                    <div class="field">
                        <label for="">链接</label>
                        <input type="text" name="redirect_path" placeholder="链接示例 /wechat/apply">
                    </div>
                </div>


                <div class="ui info message">
                    文章和链接只需要填写一个，若同时填写，则以链接为准。
                </div>

                <!--任务简称-->
                <div class="field">
                    <label for="">导航图</label>
                    <div class="ui segment clear-shadow">
                        <div id="imageBox" class="ui one special cards headimg_box" data-limit="1" style="width:30%;">
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


                <button id="navSubmit" class="ui blue button submit" style="margin-top: 20px;">提交</button>
                <div class="ui error message"></div>
                @include("admin.layout.message")
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <input type="hidden" name="article_id">
                <input type="hidden" name="image_path" placeholder="导航图">
            </form>
        </div>

    </div>
    <!--页面标题end-->


    </body>
@endsection