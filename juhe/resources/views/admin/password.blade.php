@extends('admin.layout.frame')
@section('content')
    <body class="m0p0" style="position: relative;">
    <!--页面标题-->
    <div class="ui header m8">修改密码</div>
    <div class="ui one column grid columns feeds">
        <div class="column">
            <form id="resetPasswordForm" class="ui form " action="{{url('admin/reset/password')}}" method="post">
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
                    <button class="ui blue button submit">修改
                    </button>
                </div>

                {{csrf_field()}}

                <div class="m8">
                    @include('wechat.layout.message')
                </div>
                <div class="ui error message m8"></div>
            </form>
        </div>
    </div>

    </body>
@endsection