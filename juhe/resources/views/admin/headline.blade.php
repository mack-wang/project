@extends('admin.layout.frame')
@section('content')
    <body style="overflow: auto;">
    <!--页面标题-->
    <div class="ui header m8">钜合头条</div>
    <!--页面标题end-->
    <table class="ui celled table">
        <thead>
        <tr>
            <th>编号</th>
            <th>头条内容</th>
            <th>文章</th>
            <th>阅读数</th>
            <th>编辑</th>
            <th>删除</th>
        </tr>
        </thead>
        <tbody>
        @foreach($headlines as $headline)
            <tr>
                <td>{{$headline->id}}</td>
                <td>{{$headline->headline}}</td>
                <td>{{$headline->articles->title or '/'}}</td>
                <td>{{$headline->view}}</td>
                <td><a class="edit headline" data-value="{{$headline->id}}">编辑</a></td>
                <td>
                    <a href="{{url('admin/index/delHeadline/'.$headline->id)}}"
                       onclick="return confirm('是否确定删除头条？')">
                        删除
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="8">
                {{$headlines->links()}}
            </th>
        </tr>
        </tfoot>
    </table>
    <form class="ui form" id="headlineForm" action="{{url('admin/index/headline/form')}}" method="post">
        <div class="field">
            <label for="">头条内容</label>
            <input type="text" name="headline" placeholder="头条内容" value="{{old('catalog')}}">
        </div>
        <div class="field">
            <label for="">文章</label>
            <div id="articleSearch" class="ui search article">
                <div class="ui fluid  icon input">
                    <input id="articleTitle" class="prompt" type="text" placeholder="选择文章">
                    <i class="search icon"></i>
                </div>
                <div class="results"></div>
            </div>
        </div>
        <button id="headlineSubmit" class="ui blue submit button">添加新头条</button>
        <input type="hidden" name="id" value="{{old('id')}}">
        <input type="hidden" name="article_id">
        {{csrf_field()}}
        @include('admin.layout.message')
    </form>

    </body>
@endsection