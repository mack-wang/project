@extends('wechat.layout.frame-slide',['title' => "兑奖二维码"])
@section('content')
    <body style="position: relative">

    <div style="margin: 20px;">


        <table class="ui celled table">
            <thead>
            <tr>
                <th> <i class="ui help circle icon"></i>帮助信息</th>
            </tr>
            </thead>
            <tbody>
            @foreach($helps as $help)
            <tr>
                <td>
                    <a href="{{url('wechat/article/'.$help->article_id)}}">{{$help->articles->title}}</a>
                </td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>

    <div class="m8">
        @include('wechat.layout.message')
    </div>
    <div style="width: 100%;height: 50px;"></div>
    <a href="{{url('wechat/home')}}" class="ui fluid green button absolute bottom">返回个人中心</a>
    </body>
@endsection
