@extends('admin.layout.editor-frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">编辑任务活动</div>

    <div class="ui text container pb100">
        <form id="task-form" action="{{url('admin/activity/task_form')}}" class="ui form bigLabel"
              method="post">
            <div class="two fields">
                <div class="field">
                    <label for="">任务标题</label>
                    <input type="text" name="title" placeholder="添加任务标题">
                </div>

                <div class="field">
                    <label for="">任务简称</label>
                    <input type="text" name="message" placeholder="添加任务简称">
                </div>
            </div>

            <div class="two fields">
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

            <div class="three fields">

                <div class="field">
                    <label>任务类型</label>
                    <select class="ui selection dropdown" name="task_type">
                        <option selected value="all">通用</option>
                        <option value="airport">机场</option>
                        <option value="shop">烟店</option>
                    </select>
                </div>

                <div class="field">
                    <label>奖励数量</label>
                    <input type="text" name="prize_count" placeholder="请输入奖励数量">
                </div>
                <div class="field">
                    <label>奖品类型</label>
                    <select class="ui selection dropdown prize" name="prize_type">
                        <option selected value="water">滴水</option>
                        <option value="seed">颗种子</option>
                        <option value="ticket">张礼品券</option>
                    </select>
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
                <label for="">任务链接</label>
                <input type="text" name="link" placeholder="例如：/wechat/link/takephoto">
                <div class="ui message info">活动链接会覆盖活动内容，若未开发活动链接，可跳过此项</div>
            </div>

            <div class="three fields">
                <div class="field">
                    <label>置顶</label>
                    <input type="text" name="top" placeholder="输入1，即置顶">
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

            <button id="task-save" class="ui basic button submit">存为草稿</button>
            <button id="task-submit" class="ui primary button submit">发布</button>

            <div class="ui error message"></div>
            @include('admin.layout.message')

            {{ csrf_field() }}
            <input type="hidden" name="off" value="0">
            <input type="hidden" name="type" value="task">
            <input type="hidden" name="prize_name" placeholder="奖品名称">
            <input type="hidden" name="question_id" placeholder="任务题目">
            <input type="hidden" name="article_id" placeholder="文章">
        </form>
    </div>
    </body>
    <script>
        $('.dropdown').dropdown();
    </script>
@endsection