@extends('wechat.layout.frame-slide')
@section('content')
    <style>
        .ui.modal{
            top:40%;
        }
    </style>
    <body>
    {{--验证弹窗--}}
    <div class="ui apply modal">
        <div class="header">验证问题</div>
        @if($question->questions->image_path != null)
            <img class="ui image" src="{{asset($question->questions->image_path)}}" alt="">
        @endif
        <div class="content">
            <form class="ui apply form" method="POST" action="{{url('wechat/activity/questionForTask')}}"
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

                <input type="hidden" name="selected">
                <input type="hidden" name="activity_id" value="{{$question->activity_id}}">
                <input type="hidden" name="question_id" value="{{$question->questions->id}}">
                <input type="hidden" name="type" value="{{$question->questions->type}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">

                @include('wechat.layout.message')
            </form>
        </div>
        <div class="actions">
            <div class="ui cancel button">返回</div>
            <div class="ui green approve button">提交</div>
        </div>
        {{--验证弹窗end--}}
    </div>
    <script>
        $('.ui.question.radio.checkbox').checkbox();
        $('.ui.apply.modal')
            .modal('setting',{detachable:false,observeChanges:true})
            .modal({
                onDeny: function () {
                    location.href = "{{url('wechat/grass/index')}}";
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

        @if(session('success'))
            setTimeout(function () {
            location.href = "{{url('wechat/grass/index')}}";
        }, 3000);
        @endif
    </script>
    </body>
@endsection