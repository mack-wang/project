@extends('admin.layout.editor-frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">添加题目</div>
    <!--页面标题end-->

    <div class="ui grid pb100">
        <!--添加文章属性-->
        <div class="four wide computer sixteen wide mobile column">
            <form id="questionForm" action="{{url('admin/activity/question')}}" class="ui form" method="post">

                <!--类型选择-->
                <div class="ui top attached header">
                    题目类型
                </div>
                <div class="ui bottom attached segment">
                    <div class="inline fields">
                        <label style="display: none">题目类型</label>
                        <div class="field">
                            <select class="ui selection dropdown" name="type">
                                <option selected value="radio">单选</option>
                                <option value="select">多选</option>
                                <option value="photo">照片</option>
                                <option value="input">文字</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="ui top attached header">
                    题目配图
                </div>
                <div class="ui bottom  attached segment">
                    <div id="headimg_box" class="ui one special cards headimg_box" data-limit="1">

                    </div>
                    <div class="ui hidden divider"></div>
                    <div id="headimg_add" class="ui big basic icon button">
                        <i class="ui icon add"></i>
                    </div>
                </div>

                <!--任务简称-->
                <div class="ui top attached header">
                    题目
                </div>
                <div class="ui bottom  attached segment">
                    <div class="field">
                        <input type="text" name="question" placeholder="题目">
                    </div>
                </div>


                <div id="option-frame">
                    <div class="ui top attached header">
                        单选/多选选项
                        <a id="selected_add" class="fr"><i class="ui large yu-add icon"></i></a>
                        <a id="selected_minus" class="fr pr8"><i class="ui large yu-minus icon"></i></a>
                    </div>
                    <div id="selected" class="ui bottom attached segment">
                        <div class="tow fields">
                            <div class="field" style="margin:auto 0;">
                                <div class="ui question checkbox">
                                    <input type="checkbox">
                                    <label for="" hidden></label>
                                </div>
                            </div>
                            <div class="field">
                                <input type="text" class="options" placeholder="选项">
                            </div>
                        </div>
                    </div>

                    <div class="ui info message">
                        <div class="ui bulleted list">
                            <div class="item">勾选则为正确答案</div>
                            <div class="item">不勾选任何答案则为开放式题目</div>
                            <div class="item">照片和文字类型题目，忽略选项</div>
                        </div>
                    </div>
                </div>


                <div id="questionSubmit" class="ui fluid green button" style="margin-top: 20px;">提交</div>

                <div class="ui error message"></div>
                @include("admin.layout.message")
                {{ csrf_field() }}
                <input type="hidden" name="selected">
                <input type="hidden" name="options">
                <input type="hidden" name="image_path">
                <input type="hidden" name="id">
            </form>
        </div>

        <div class="twelve wide computer sixteen wide mobile column">
            <table class="ui unstackable striped table" id="shop-table">
                <thead>
                <tr>
                    <th>编号</th>
                    <th>类型</th>
                    <th>题目配图</th>
                    <th>题目</th>
                    <th>选项</th>
                    <th>正确答案</th>
                    <th>日期</th>
                    <th>编辑</th>
                    <th>软删除</th>
                </tr>
                </thead>
                <tbody>
                @foreach($questions as $question)
                    <tr>
                        <td>
                            {{$question->id}}
                        </td>
                        <td data-value="{{$question->type}}">
                            {{$type[$question->type]}}
                        </td>
                        <td data-value="{{$question->image_path}}">
                            @if($question->image_path)
                                <img class="ui tiny image" src="{{url($question->image_path)}}" alt="">
                            @else
                                <img class="ui tiny image" src="{{url('img/image.png')}}" alt="">
                            @endif
                        </td>
                        <td>{{$question->question}}</td>
                        <td>{{$question->options}}</td>
                        <td>{{$question->selected}}</td>
                        <td>{{ date("Y-m-d",strtotime($question->created_at)) }}</td>
                        <td><a class="questionEdit" href="">编辑</a></td>
                        <td><a class="questionDelete" onclick="return confirm('是否确定删除？')"
                               href="{{url('admin/question/delete').'/'.($question->id)}}">删除</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $questions->links() }}
        </div>

    </div>
    <!--页面标题end-->


    <div style="display: none;">
        <script id="container2" name="content2" type="text/plain"></script>
    </div>

    <script>

        //启动dropdown
        $('.ui.dropdown').dropdown({
            onChange: function (value, text, $choice) {
                if (value === 'photo' || value === 'input') {
                    $('#option-frame').hide();
                } else {
                    $('#option-frame').show();
                }
            }
        });


        $('.ui.rating').rating({
            maxRating: 5
        });

        $('.set-top').checkbox();

        $('.special.cards .image').dimmer({
            on: 'hover'
        });

        //上传活动头图
        var ue2 = UE.getEditor('container2');
        ue2.ready(function () {
            //此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
            ue2.setHide();
            ue2.execCommand('serverparam', '_token', '{{csrf_token()}}');

            //弹出图片上传的对话框
            $("#headimg_add").click(function () {
                ue2.getDialog("insertimage").open();
            });

            ue2.addListener('beforeInsertImage', function (t, arg) {
                var headimg =
                    '<div class="card">'
                    + '<div class="blurring dimmable image">'
                    + '<div class="ui dimmer">'
                    + '<div class="content">'
                    + '<div class="center">'
                    + '<div class="ui inverted button delete">删除</div>'
                    + '</div>'
                    + '</div>'
                    + '</div>'
                    + '<img data-value="' + arg[0].src + '" src="' + '{{url('/')}}' + '/' + arg[0].src + '">'
                    + '</div>'
                    + '</div>';

                var limit = $('.headimg_box').attr('data-limit');
                if ($(".headimg_box img").length == limit) {
                    alert("最多上传" + limit + "张图！");
                    return false;
                }

                $("#headimg_box").append(headimg);

                $('.headimg_box.special.cards .image').dimmer({
                    on: 'hover'
                });

                $('.headimg_box.special.cards .delete').click(function () {
                    $(this).closest('.card').remove();
                });
            });
//            ue2.addListener('afterUpfile', function (t, arg) {
//                alert(arg[0].url);
//            });
        });


    </script>
    </body>
@endsection