@extends('admin.layout.ueditor')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">编辑文章</div>
    <!--页面标题end-->


    <div class="ui centered grid pb100">
        <!--添加文章-->
        <div class="six wide computer sixteen wide mobile column">
            <form id="articleForm" action="{{url('admin/article')}}" class="ui form" method="post">
                <div class="field">
                    <input type="text" placeholder="添加文章标题" name="title">
                </div>
                <div class="field" style="width: 100%;">
                    <script id="ueditor" type="text/plain"></script>
                </div>
                <div id="articleSubmit" class="ui submit green button">上传新文章</div>
                <div class="ui error message"></div>
                @include('admin.layout.message')
                {{ csrf_field() }}
                <input type="hidden" name="content" placeholder="文章">
                <input type="hidden" name="id">
            </form>
        </div>

        <div class="ten wide computer sixteen wide mobile column">
            <form action="{{url('admin/article/search/')}}" method="get">
                <div class="ui action input">
                    <input type="text" name="title" placeholder="搜索文章" value="{{$title or ""}}">
                    <button class="ui icon button">
                        <i class="search icon"></i>
                    </button>
                </div>
            </form>
            <table class="ui unstackable striped table" id="shop-table">
                <thead>
                <tr>
                    <th>编号</th>
                    <th>标题</th>
                    <th>绑定活动数</th>
                    <th>更新日期</th>
                    <th>帮助</th>
                    <th>编辑</th>
                    <th>删除</th>
                </tr>
                </thead>
                <tbody>
                @foreach($articles as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->title or '/'}}</td>
                        <td>{{$item->activities->count()}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            @if($item->help_articles != null)
                                <div class="ui fitted checkbox helpArticles">
                                    <input type="checkbox" checked="checked" value="{{$item->id}}">
                                    <label></label>
                                </div>
                            @else
                                <div class="ui fitted checkbox helpArticles">
                                    <input type="checkbox" value="{{$item->id}}">
                                    <label></label>
                                </div>
                            @endif
                        </td>
                        <td><a class="articleEdit" data-value="{{$item->id}}">编辑</a></td>
                        <td>
                            @if($item->activities->isEmpty())
                                <a onclick="return confirm('是否确定删除？')"
                                   href="{{url('admin/article/delete').'/'.($item->id)}}">
                                    删除
                                </a>
                            @else
                                <a style="color:gray;">
                                    删除
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(isset($title))
                {{$articles->appends(["title" => $title])->links()}}
            @else
                {{$articles->links()}}
            @endif
        </div>

    </div>


    </body>
@endsection