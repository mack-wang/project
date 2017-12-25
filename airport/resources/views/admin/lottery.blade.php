@extends('admin.layout.editor-frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui grid pb100">


        <!--添加文章属性-->

        <div class="four wide computer sixteen wide mobile column">
            <form id="lotteryForm" action="{{url('admin/lottery/form')}}" class="ui form" method="post">
                <!--任务简称-->
                {{--@foreach($lotteries as $item)--}}

                {{--@endforeach--}}

                <button class="ui fluid green button submit" style="margin-top: 20px;">修改</button>
                <div class="ui error message"></div>
                @include("admin.layout.message")
                {{ csrf_field() }}
            </form>
        </div>
    </div>
    <!--页面标题end-->

    </body>
@endsection