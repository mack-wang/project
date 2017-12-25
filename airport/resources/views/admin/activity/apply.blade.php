@extends('admin.layout.editor-frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">编辑测评活动</div>

    <div class="ui text container pb100">
        <form id="article-form" action="{{url('admin/activity/article')}}" class="ui form bigLabel" method="post">
            <div class="field">
                <label for="">测评活动标题</label>
                <input type="text" name="title" placeholder="添加测评活动标题">
            </div>

            <div class="three fields">
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

                <div class="field">
                    <label for="">测评卷烟品牌</label>
                    <div class="ui fluid search brand">
                        <div class="ui fluid  icon input">
                            <input class="prompt" type="text" placeholder="测评卷烟品牌">
                            <i class="search icon"></i>
                        </div>
                        <div class="results"></div>
                    </div>
                </div>

                <div class="field">
                    <label for="">验证题目</label>
                    <div class="ui fluid search question">
                        <div class="ui fluid  icon input">
                            <input class="prompt" type="text" placeholder="验证题目">
                            <i class="search icon"></i>
                        </div>
                        <div class="results"></div>
                    </div>
                </div>
            </div>
            <div class="field">
                <label for="">奖品描述</label>
                <input type="text" name="description" placeholder="每条描述用英文逗号分开">
            </div>

            <div class="three fields">
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
                <div class="field">
                    <label for="">筛选方式(0为自动，1为人工)</label>
                    <input type="text" name="elect" value="0">
                </div>
            </div>

            <!--活动轮播图模块-->
            <div class="field">
                <label for="">活动轮播图</label>
                <div class="ui segment clear-shadow">
                    <div id="imageBox" class="ui four special cards headimg_box" data-limit="4">
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
                    <label>输入测评名额</label>
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

            <button id="article-save" class="ui basic button submit">存为草稿</button>
            <button id="article-submit" class="ui primary button submit">发布</button>

            <div class="ui error message"></div>
            @include('admin.layout.message')

            {{ csrf_field() }}
            <input type="hidden" name="off" value="0">
            <input type="hidden" name="article_id" placeholder="文章">
            <input type="hidden" name="cigarette_id" placeholder="卷烟品牌">
            <input type="hidden" name="question_id" placeholder="验证题目">
            <input type="hidden" name="image_path" placeholder="轮播图">
            <input type="hidden" name="type" value="apply">
        </form>
    </div>
    </body>
@endsection