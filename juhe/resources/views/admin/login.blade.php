@extends('admin.layout.frame')
@section('content')
    <body style="overflow: hidden;">
    <div class="ui text container">
        <img src="{{asset('img/juhe.png')}}" alt="" class="ui centered small image mt200">
        <h2 class="ui center aligned icon header ">
            <div class="content">
                钜合团购管理后台
                <div class="sub header">www.juhetuangou.com</div>
            </div>
        </h2>
        <div class="ui blue segment ">
            <form class="ui form" action="{{url('admin/login')}}" method="post">
                <div class="field">
                    <label>管理账号</label>
                    <input type="text" name="name" placeholder="请输入账号" value="{{old('name')}}">
                </div>
                <div class="field">
                    <label>管理密码</label>
                    <input type="password" name="password" placeholder="请输入密码" value="{{old('password')}}">
                    {{ csrf_field() }}
                </div>
                <button class="ui blue button" type="submit">登入</button>
            </form>
            @if(session('error'))
                <div class="ui error message">{{session('error')}}</div>
            @endif
        </div>
    </div>
    </body>
@endsection