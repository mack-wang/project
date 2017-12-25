@extends('wechat.layout.frame-slide')
@section('content')
    <style>
        .ui.modal{
            top:40%;
        }
    </style>
    <body>
    <div class="ui one column grid columns feeds">
        {{--轮播图--}}
        <div class="column">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach(str_getcsv($activity->activity_headimgs->image_path) as $image_path)
                        <div class="swiper-slide">
                            <img class="ui image slide" src="{{asset($image_path)}}" alt="">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        {{--轮播图end--}}


        {{--导航说明--}}
        <div class="column">
            <div class="ui green inverted three item menu apply clear-shadow clear-radio">
                <div class="fitted item">
                    <div>
                        <div class="lighter text">试用名额</div>
                        <div>{{$activity->activity_prizes->count}}个</div>
                    </div>
                </div>
                <div class="fitted item">
                    <div>
                        <div class="lighter text">试用条件</div>
                        @if($activity->activity_requires->exp != null)
                            <div>
                                经验{{$activity->activity_requires->exp}}点以上
                            </div>
                        @endif
                        @if($activity->activity_requires->level != null)
                            <div>
                                等级{{$activity->activity_requires->level}}星以上
                            </div>
                        @endif
                    </div>
                </div>
                <div class="right floated item">
                    <div>
                        <div class="lighter text">距结束仅剩</div>
                        <div>
                            @php
                                $time = \App\Helper::secondToDivide(strtotime($activity->end_at)-time());
                                echo '<span class="time">'.$time['day'].'</span> : ';
                                echo '<span class="time">'.$time['hour'].'</span> : ';
                                echo '<span class="time">'.$time['minute'].'</span> : ';
                                echo '<span class="time">'.$time['second'].'</span>';
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--导航说明end--}}



        {{--活动标题--}}
        <div class="column">
            <div class="ui segment">
                <div class="ui small lighter header p8">
                    <i class="red yu-fire icon p0m0"></i>
                    {{$activity->activity_attrs->title}}
                </div>
            </div>
        </div>
        {{--活动标题end--}}


        {{--奖品描述--}}
        @include("admin.layout.prize-description")
        {{--奖品描述end--}}
        <div class="column">
            <div class="ui segment border-clear" style="padding: 10px!important;">
                <div class="ui green four item menu borderless m0 clear-shadow ">
                    <div class="item active">试用申请</div>
                    <div class="item">后台筛选</div>
                    <div class="item">邮寄产品</div>
                    <div class="item" >试用评价</div>
                </div>
            </div>
        </div>
        {{--活动内容--}}
        <div class="column" style="background-color: white;">
            <div class="mt8">
                {!! $activity->articles->content !!}
            </div>
        </div>
        {{--活动内容end--}}


        {{--活动规则及流程--}}
        @include('wechat.layout.rule')
        {{--活动规则及流程end--}}

        {{--警示提示--}}
        @include('wechat.layout.record')
        {{--警示提示end--}}
    </div>
    {{--底部菜单--}}
    <div class="ui bottom fixed three item apply menu">
        <div class="fitted item">
            <div>
                <div class="lighter text">市场价</div>
                <div class="strong text">{{$activity->fetch_cigarettes->status ? $activity->fetch_cigarettes->price."元/个" : ($activity->fetch_cigarettes->price/10)."元/包"}}</div>
            </div>
        </div>
        <div class="fitted item">
            <div>
                <div class="lighter text">已申请人数</div>
                <div class="strong text">{{$activity->result_applies->count()}}人</div>
            </div>
        </div>
        @if(!$applied)
            <div id="apply" class="item applied">
                马上申请
            </div>
        @else
            <div class="item applied">
                已申请
            </div>
        @endif
    </div>
    {{--底部菜单end--}}

    {{--验证弹窗--}}
    @if($question != null)
        <div class="ui apply modal">
            <div class="header">验证问题</div>
            @if($question->questions->image_path != null)
                <img class="ui image" src="{{asset($question->questions->image_path)}}" alt="">
            @endif
            <div class="content">
                <form class="ui apply form" method="POST" action="{{url('wechat/activity/question')}}"
                      @if($question->questions->type == "photo") enctype="multipart/form-data" @endif >
                    <div class="grouped fields">
                        <label class="f16">{{$question->questions->question}}</label>
                        @if($question->questions->type == "radio")
                            @foreach(str_getcsv($question->questions->options) as $option)
                                <div class="field">
                                    <div class="ui question radio checkbox">
                                        <input type="radio" name="radio" value="{{$loop->iteration}}">
                                        <label>{{$option}}</label>
                                    </div>
                                </div>
                            @endforeach
                                <input type="hidden" name="selected">
                        @elseif($question->questions->type == "select")
                            @foreach(str_getcsv($question->questions->options) as $option)
                                <div class="field">
                                    <div class="ui question checkbox multi">
                                        <input type="checkbox" value="{{$loop->iteration}}">
                                        <label>{{$option}}</label>
                                    </div>
                                </div>
                            @endforeach
                                <input type="hidden" name="selected">
                        @elseif($question->questions->type == "photo")
                            <div class="field">
                                <input type="file" name="photo" placeholder="选取照片">
                            </div>
                        @elseif($question->questions->type == "input")
                            <div class="field">
                                <input type="text" name="input" placeholder="请输入">
                            </div>
                        @endif
                    </div>

                    <input type="hidden" name="activity_id" value="{{$question->activity_id}}">
                    <input type="hidden" name="question_id" value="{{$question->questions->id}}">
                    <input type="hidden" name="type" value="{{$question->questions->type}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                </form>
            </div>
            <div class="actions">
                <div class="ui cancel button">取消</div>
                <div class="ui green approve button">提交</div>
            </div>
            @endif
            {{--验证弹窗end--}}
        </div>


        <script>
            $('.ui.question.radio.checkbox').checkbox();

            var mySwiper = new Swiper('.swiper-container', {
                autoplay: 5000,
                speed: 1000,
                direction: 'horizontal',
                loop: true,
                pagination: '.swiper-pagination',
                paginationType: 'bullets'
            });

            $('#apply').click(function () {
                if ($('.agreement.checkbox').checkbox('is unchecked')) {
                    alert("请确认已经阅读活动规则！");
                    return false;
                }

                $.ajax({
                    type: 'GET',
                    url: '{{url("wechat/activity/requires")."/".$activity->id}}',
                    success: function (auth) {
                        if(auth == "unlogin"){
                            location.href = "{{url('wechat/login')}}";
                            return false;
                        }

                        if(auth == "shop_error"){
                            alert("你未绑定终端，不可以参与申请试用。用微信扫终端二维码，即可绑定。");
                            return false;
                        }

                        if (auth == "exp_error") {
                            alert("你的经验未达到{{$activity->activity_requires->exp}}点以上,不能申请。可以到首页上的去种草，增加经验哦！");
                            return false;
                        }

                        if (auth == "level_error") {
                            alert("你的等级未达到{{$activity->activity_requires->level}}星以上,不能申请。可以到首页上的去种草，增加等级哦！");
                            return false;
                        }

                        if (auth == "success") {
                            $('.ui.apply.modal')
                                .modal('setting',{detachable:false,observeChanges:true})
                                .modal({
                                    onDeny: function () {
                                        return true;
                                    },
                                    onApprove: function () {

                                        if($('.ui.question.checkbox').length > 0){
                                            var selected = '';
                                            $('.question.checkbox').each(function () {
                                                if ($(this).checkbox('is checked')) {
                                                    selected += $(this).find('input').val();
                                                }
                                            });
                                            $('.apply.form').form('set value', 'selected', selected);
                                        }

                                        $('.apply.form').submit();
                                        return true;
                                    }
                                })
                                .modal('show')
                                .modal('refresh');

                            if($('.ui.apply.modal').length === 0){
                                location.href = "{{url('wechat/activity/withoutQuestion/'.$activity->id)}}";
                            }

                        }
                    },
                    error: function () {
                        location.href = "{{url('wechat/login')}}";
                    },
                    dataType: 'text'
                });
            });

            @if(session('success'))
alert('申请成功');
            @elseif(session('error'))
alert('选择错误');
            @elseif(session('error2'))
                alert('你未绑定终端，不可以参与申请试用。用微信扫终端二维码，即可绑定。');
            @endif
        </script>

    </body>
@endsection