@extends('admin.layout.frame')
@section('content')
    <body style="overflow: auto;">
    <!--页面标题-->
    <div class="ui header m8">目录管理</div>
    <!--页面标题end-->
    <table class="ui celled table">
        <thead>
        <tr>
            <th>目录编号</th>
            <th>目录名称</th>
            <th>文章数</th>
            <th>首页展示</th>
            <th>状态</th>
            <th>置顶</th>
            <th>编辑</th>
            <th>删除</th>
        </tr>
        </thead>
        <tbody>
        @foreach($catalogs as $catalog)
            <tr>
                <td>{{$catalog->id}}</td>
                <td>{{$catalog->catalog}}</td>
                <td>{{$catalog->articles->count()}}</td>
                <td>
                    <div class="ui checkbox recommend">
                        <input type="checkbox" {{ $catalog->recommend ? "checked" : "" }} value="{{$catalog->id}}">
                        <label>首页展示</label>
                    </div>
                </td>
                <td>
                    <div class="ui checkbox off">
                        <input type="checkbox" {{ $catalog->off ? "checked" : "" }} value="{{$catalog->id}}">
                        <label>关闭</label>
                    </div>
                </td>
                <td>
                    <div class="ui checkbox top">
                        <input type="checkbox" {{ $catalog->top ? "checked" : "" }} value="{{$catalog->id}}">
                        <label>置顶</label>
                    </div>
                </td>
                <td><a class="edit catalog">编辑</a></td>
                <td>
                    @if($catalog->auth != 1)
                        <a href="{{url('admin/product/delCatalog'."/$catalog->id")}}"
                           onclick="return confirm('是否确定删除目录？')">
                            删除
                        </a>
                    @else
                        <a style="color:gray">
                            删除
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="8">
                {{$catalogs->links()}}
            </th>
        </tr>
        </tfoot>
    </table>
    <form id="catalogForm" action="{{url('admin/product/addCatalog')}}" method="get">
        <div class="field">
            <div class="ui action input">
                <input type="text" name="catalog" placeholder="输入目录名称" value="{{old('catalog')}}">
                <button class="ui blue button catalog">添加新目录</button>
            </div>
        </div>
        <input type="hidden" name="id" value="{{old('id')}}">
        @include('admin.layout.message')
    </form>

    </body>
@endsection