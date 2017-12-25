@extends('admin.layout.frame')
@section('content')
    <body style="overflow: auto;">
    <!--页面标题-->
    <div class="ui header m8">文章管理</div>
    <!--页面标题end-->
    <!--筛选和搜索菜单-->


    <!--搜索文章-->

    <form action="{{url('admin/article/search')}}" class="ui form" method="post">
        <div class="ui action input">
            <input type="text" name="value" placeholder="请输入">
            <select class="ui selection dropdown" name="search" style="width: 200px">
                <option value="catalog">目录</option>
                <option value="brand">品牌</option>
                <option value="title">标题</option>
            </select>
            {{csrf_field()}}
            <button id="search_article" class="ui submit button">搜索</button>
        </div>
    </form>

    <!--搜索文章end-->

    <table class="ui celled table">
        <thead>
        <tr>
            <th>文章编号</th>
            <th>目录</th>
            <th>品牌</th>
            <th>标题图</th>
            <th>标题</th>
            <th>简介</th>
            <th>置顶</th>
            <th>编辑</th>
            <th>删除</th>
        </tr>
        </thead>
        <tbody>
        @foreach($articles as $article)
            <tr>
                <td>{{$article->id}}</td>
                <td data-value="{{$article->catalogs->id}}">{{$article->catalogs->catalog}}</td>
                <td>{{$article->brand}}</td>
                <td><img class="ui tiny image" src="{{asset($article->image)}}" alt=""></td>
                <td>{{$article->title}}</td>
                <td>{{$article->brief}}</td>
                <td>
                    <div class="ui checkbox article-top">
                        <input type="checkbox" {{ $article->top ? "checked" : "" }} value="{{$article->id}}">
                        <label>置顶</label>
                    </div>
                </td>
                <td class="one wide"><a href="{{url('admin/product/show/editArticle/'.$article->id)}}">编辑</a></td>
                <td class="one wide">
                    <a href="{{url('admin/product/delArticle/'.$article->id)}}"
                       onclick="return confirm('是否确定删除文章？')">
                        删除
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="10">
                {{$articles->links()}}
            </th>
        </tr>
        </tfoot>
    </table>
    @include('admin.layout.message')

    </body>
@endsection