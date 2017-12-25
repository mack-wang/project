@extends('wechat.layout.frame',['title' => "修改邮寄信息"])
@section('content')
    <body class="m0p0" style="position: relative;">
    <div class="ui one column grid columns feeds">
        <div class="column">
            <div class="ui segment mt8">
                <div class="ui feed">
                    <div class="event">
                        <div class="content" style="padding: 6px 0 0 8px;">
                            <div class="summary">
                                {{$user->user_attrs->real_name}} {{$user->mail_phone}}
                            </div>
                            <div class="meta">
                                {{$address}}
                            </div>
                        </div>
                        <a href="{{url('wechat/home')}}" class="feeds button">
                            返回
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="ui  segment mt8">
                <form id="update-address" class="ui form m8" action="{{url('wechat/home/address')}}" method="post">
                    <div class="ui header">修改邮寄信息</div>
                    <div class="field">
                        <div class="ui two column horizontal grid">
                            <div class="column pr8">

                                <input type="text" name="real_name" placeholder="测评收件人姓名"
                                       value="{{$user->user_attrs->real_name}}">
                            </div>
                            <div class="column pr8">

                                <input type="text" name="mail_phone" placeholder="收件手机号"
                                       value="{{$user->mail_phone}}">
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui three column horizontal grid">
                            <div class="column pr8">
                                <div class="field">
                                    <label style="display: none;">省份</label>
                                    <select name="province" id="province">
                                        <option value="">省份</option>
                                    </select>
                                </div>
                            </div>
                            <div class="column pr8">
                                <div class="field">
                                    <label style="display: none;">市区</label>
                                    <select name="city" id="city">
                                        <option value="">市区</option>
                                    </select>
                                </div>
                            </div>
                            <div class="column pr8">
                                <div class="field">
                                    <label style="display: none;">街道</label>
                                    <select name="area" id="area">
                                        <option value="">街道</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <input type="text" name="address" placeholder="具体地址，至少2个字" value="{{$user->address}}">
                    </div>
                    {{csrf_field()}}

                    {{--接收响应信息--}}
                    @include('wechat.layout.message')

                    <div class="ui error message"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="ui modal info"></div>

    <button id="address-submit" class="ui fluid green button absolute bottom">修改</button>
    </body>
    <script>
        $.get('{{url('wechat/search/city/0')}}', function (data) {
            var $province = $('#province');
            $.each(data, function (index, item) {
                var option = '<option value="' +
                        item['id'] +
                        '">' +
                        item['name'] +
                        '</option>';
                $province.append(option);
            })
        }, 'json');

        $('#address-submit').click(function () {
            $('form').submit();
        });
    </script>
@endsection