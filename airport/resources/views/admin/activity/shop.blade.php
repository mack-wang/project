@extends('admin.layout.editor-frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">编辑烟店活动</div>

    <div class="ui text container pb100">
        <form id="articleOnly-form" action="{{url('admin/activity/articleOnly')}}" class="ui form bigLabel" method="post">
            <div class="field">
                <label for="">活动标题</label>
                <input type="text" name="message" placeholder="添加活动标题">
            </div>
            <div class="field">
                <label for="">活动按钮文字</label>
                <input type="text" name="button" placeholder="添加活动按钮文字">
            </div>

            <div class="field">
                <label for="">选择文章</label>
                <div id="articleSearch" class="ui fluid search article">
                    <div class="ui fluid  icon input">
                        <input id="articleTitle" class="prompt" type="text" placeholder="选择文章">
                        <i class="search icon"></i>
                    </div>
                    <div class="results"></div>
                </div>
            </div>

            <div class="two fields">
                <div class="field">
                    <label for="">开始时间</label>
                    <div class="ui calendar" id="rangestart">
                        <div class="ui input left icon">
                            <i class="calendar icon"></i>
                            <input type="text" name="start_at" placeholder="开始时间">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label for="">结束时间</label>
                    <div class="ui calendar" id="rangeend">
                        <div class="ui input left icon">
                            <i class="calendar icon"></i>
                            <input type="text" name="end_at" placeholder="结束时间">
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <label for="活动链接"></label>
                <input type="text" name="link" placeholder="例如：/wechat/link/takephoto">
                <div class="ui message info">
                    活动链接会覆盖活动内容，若未开发活动链接，可跳过此项<br>
                    最多可上传两张图，第一张为首页图，第二张为活动头像（头像可省略）
                </div>
            </div>

            <!--活动轮播图模块-->
            <div class="field">
                <label for="">活动首页图</label>
                <div class="ui segment clear-shadow">
                    <div id="imageBox" class="ui four special cards headimg_box" data-limit="2">
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

            <div class="three fields">
                <div class="field">
                    <label>输入名额</label>
                    <input type="text" name="count" placeholder="输入测评名额">
                </div>
                <div class="field">
                    <label>等级条件</label>
                    <input type="text" name="level" placeholder="1~5">
                </div>
                <div class="field">
                    <label>经验条件</label>
                    <input type="text" name="exp" placeholder="100~1000">
                </div>
            </div>

            <button id="articleOnly-save" class="ui basic button submit">存为草稿</button>
            <button id="articleOnly-submit" class="ui primary button submit">发布</button>

            <div class="ui error message"></div>
            @include('admin.layout.message')

            {{ csrf_field() }}
            <input type="hidden" name="off" value="0">
            <input type="hidden" name="article_id" placeholder="文章">
            <input type="hidden" name="image_path" placeholder="活动首页图">
            <input type="hidden" name="type" value="shop">
        </form>
    </div>
    </body>
@endsection