@extends('admin.layout.editor-frame')
@section('content')
    <body style="overflow: auto;">
    <!--页面标题-->
    <div class="ui header m8">编辑文章</div>
    <!--页面标题end-->

        <form action="{{url('admin/product/addArticle')}}" method="post" id="articleForm" class="ui form">
            <div class="ui two column grid">
                <div class="six wide column">
                    <div class="field">
                        <label>标题图</label>
                        <!--活动轮播图模块-->
                        <div class="ui segment clear-shadow">
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
                    </div>
                    <div class="field">
                        <label>目录</label>
                        <select class="ui dropdown article" name="catalog_id">
                            @foreach($catalogs as $catalog)
                                <option value="{{$catalog->id}}">{{$catalog->catalog}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>品牌</label>
                        <input type="text" name="brand" placeholder="输入品牌名">
                    </div>

                    <div class="field">
                        <label>标题</label>
                        <input type="text" name="title" placeholder="输入标题">
                    </div>
                    <div class="field">
                        <label>简介</label>
                        <input type="text" name="brief" placeholder="输入简介">
                    </div>
                    <button class="ui blue button article submit">提交</button>
                    <div class="ui error message"></div>
                    @include('admin.layout.message')
                </div>
                <div class="ten wide column">
                    <label>文章内容</label>
                    <script id="ueditor" type="text/plain"></script>
                </div>
            </div>
            {{csrf_field()}}
            <input type="hidden" name="content"  placeholder="文章内容">
            <input type="hidden" name="image"  placeholder="标题图">
            <input type="hidden" name="id" >
        </form>

    <div style="height: 100px;"></div>
    <div id="modifyArticleId" style="display: none" data-value="{{$id or ''}}"></div>
    </body>
@endsection