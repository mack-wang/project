@extends('wechat.layout.frame-swiper')
@section('content')
    <body class="m0p0" style="position: relative;">
    <div class="ui one column grid columns feeds">
        <div class="row" style="margin-top: 12px;">
            <div class="three wide center aligned column">
                <i class="ui large lock icon"></i>
            </div>
            <div class="ten wide wide column p0">
                修改密码
            </div>
            <div class="three wide center aligned column">
                <a href="{{url('home')}}">
                    返回
                </a>
            </div>
        </div>
        <div class="column divider"></div>
        <div class="column">
            <form id="resetPasswordForm" class="ui form " action="{{url('wechat/reset/password')}}" method="post">
                <div class="m8">
                    <div class="field">
                        <input type="password" name="password" placeholder="原密码">
                    </div>
                    <div class="field">
                        <input type="password" name="resetPassword" placeholder="新密码">
                    </div>
                    <div class="field">
                        <input type="password" name="resetPasswordConfirm" placeholder="重复新密码">
                    </div>
                    <div>
                        <a href="{{url('wechat/reset/forget')}}">
                            *忘记密码
                        </a>
                    </div>
                </div>

                {{csrf_field()}}

                <div class="m8">
                    @include('wechat.layout.message')
                </div>
                <div class="ui error message m8"></div>
            </form>
        </div>
    </div>
    <button class="ui fixed sticky bottom fluid blue button clear-radio submit"
            style="height: 50px;">修改
    </button>
    </body>
    <script>
        $('.submit').click(function () {
            $('form').submit();
        })
    </script>
@endsection