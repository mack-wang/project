@extends('wechat.layout.frame-home')
@section('content')
    <div class="ui three column grid">
        {{--个人中心--}}
        <div class="row divider"></div>

        <div class="row">
            <div class="four wide column" style="padding: 8px 0 0 30px">
                @if($user->user_avatars != null)
                    <img class="ui circular image w60" src="{{asset($user->user_avatars->image_path)}}">
                @else
                    <img class="ui circular image w60" src="{{  asset('img/user.png')}}">
                @endif
            </div>
            <div class="eight wide column pt20">
                <div class="ui header mb4">
                    {{$user->name}}
                </div>
                <div class="meta">
                    {{$user->email}}
                </div>
            </div>
            <div class="four wide column">
                <div class="pt20">
                    <form action="{{url('wechat/home/avatar')}}" method="post" enctype="multipart/form-data">
                        <input id="avatarInput" type="file" name="avatar" style="display: none;"
                               accept="image/gif,image/jpeg,image/jpg,image/png,image/svg">
                        <a id="uploadAvatar">设置头像</a>
                    </form>
                </div>

            </div>

        </div>


        <div class="row divider"></div>


        <div class="row">
            <div class="three wide center aligned column">
                <i class="ui large building outline  icon"></i>
            </div>
            <div class="ten wide wide column p0">
                {{$user->user_companies->company or '完善公司信息'}}
            </div>
            <div class="three wide center aligned column">
                <a href="{{url('wechat/company/show')}}">
                    编辑
                </a>
            </div>
        </div>

        <div class="row divider"></div>

        <div class="row">
            <div class="three wide center aligned column">
                <i class="ui large location arrow icon"></i>
            </div>
            <div class="ten wide wide column p0">
                {{$address_str or '填写邮寄地址'}}
            </div>
            <div class="three wide center aligned column">
                <a href="{{url('wechat/address/show')}}">
                    编辑
                </a>
            </div>
        </div>

        <div class="row divider"></div>

        <div class="row">
            <div class="three wide center aligned column">
                <i class="ui large lock icon"></i>
            </div>
            <div class="ten wide wide column p0">
                修改密码
            </div>
            <div class="three wide center aligned column">
                <a href="{{url('wechat/reset/password')}}">
                    修改
                </a>
            </div>
        </div>

        <div class="row divider"></div>


        {{--<div class="row divider"></div>--}}

        {{--<div class="row">--}}
        {{--<div class="three wide center aligned column">--}}
        {{--<i class="ui large edit icon"></i>--}}
        {{--</div>--}}
        {{--<div class="ten wide wide column p0">--}}
        {{--优惠券--}}
        {{--</div>--}}
        {{--<div class="three wide center aligned column">--}}
        {{--编辑--}}
        {{--</div>--}}
        {{--</div>--}}

        <div class="row p0m0">
            <a class="ui fluid button" href="{{ route('logout') }}"
               onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
                退出
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>

    </div>
@endsection