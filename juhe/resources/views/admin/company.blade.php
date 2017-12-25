@extends('admin.layout.frame')
@section('content')
    <body style="overflow: auto;">
    <!--页面标题-->
    <div class="ui header m8">企业介绍</div>
    <!--页面标题end-->
    <form class="ui form mt20" id="companyForm" action="{{url('admin/company/form')}}" method="get">
        <div class="ui header">当前绑定文章：{{$article->title}}</div>
        <div class="field">
            <label for="">更换企业介绍文章</label>
            <div id="articleSearch" class="ui search article">
                <div class="ui fluid  icon input">
                    <input id="articleTitle" class="prompt" type="text" placeholder="搜索文章">
                    <i class="search icon"></i>
                </div>
                <div class="results"></div>
            </div>
        </div>
        <button id="companySubmit" class="ui blue submit button">修改</button>
        <div class="ui error message"></div>
        <input type="hidden" name="article_id" placeholder="企业介绍文章">
        @include('admin.layout.message')
    </form>

    </body>
@endsection