@extends('wechat.layout.frame',['title' => "注册填写"])
@section('content')
    <body class="m0p0" style="position: relative;">
    <div class="ui one column grid columns feeds">
        <div class="column">
            <div class="ui segment mt8">
                <div class="ui feed">
                    <div class="event">
                        <div class="label" style="width: 50px;padding-top: 4px;">
                            <img class="ui  image" src="{{$user->headimgurl}}">
                        </div>
                        <div class="content">
                            <div class="summary">
                                {{$user->nickname}}
                            </div>
                            <div class="meta">
                                {{$phone}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="ui  segment mt8">
                <form id="user-register" class="ui form m8" action="{{url('wechat/register')}}" method="post">
                    <div class="inline fields">
                        <label>性别</label>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="sex" checked="checked" value="1">
                                <label>男</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="sex" value="0">
                                <label>女</label>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui three column horizontal grid">
                            <div class="four wide column pr8">
                                <div class="field">
                                    <input type="number" name="age" placeholder="年龄" value="{{old('age')}}">
                                </div>
                            </div>
                            <div class="four wide column pr8">
                                <div class="field">
                                    <input type="number" name="cigarette_age" placeholder="烟龄"
                                           value="{{old('cigarette_age')}}">
                                </div>
                            </div>
                            <div class="eight wide wide column p0">
                                <div class="field">
                                    <input type="number" name="price" placeholder="常买的卷烟价格" value="{{old('price')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="ui fluid search brand">
                            <div class="ui fluid  icon input">
                                <input class="prompt" type="text" name="brand" placeholder="常抽的卷烟品牌（在搜索结果中进行选择）"
                                       value="{{old('brand')}}">
                                <i class="search icon"></i>
                            </div>
                            <div class="results"></div>
                        </div>
                    </div>
                    <div class="field brand label">

                    </div>
                    <div class="field">
                        <div class="field">
                            <div class="ui fluid search expect">
                                <div class="ui fluid  icon input">
                                    <input class="prompt" type="text" name="expect" placeholder="希望获得的卷烟品牌（在搜索结果中进行选择）"
                                           value="{{old('expect')}}">
                                    <i class="search icon"></i>
                                </div>
                                <div class="results"></div>
                            </div>
                            <div class="fr tips" style="font-size: 12px;color:gray;opacity: 0.5;">
                                *最多选择选择两个，会增加申领通过概率
                            </div>
                        </div>

                    </div>
                    <div class="field expect label">

                    </div>
                    <div class="field">
                        <div class="ui two column horizontal grid">
                            <div class="column pr8">

                                <input type="text" name="real_name" placeholder="测评收件人姓名" value="{{old('real_name')}}">
                            </div>
                            <div class="column pr8">

                                <input type="text" name="mail_phone" placeholder="收件手机号"
                                       value="{{$phone}}">
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
                        <input type="text" name="address" placeholder="具体地址，至少2个字" value="{{old('address')}}">
                    </div>
                    <div class="field">
                        <input type="text" name="recommend_code" placeholder="邀请码（若无，可不填）区分大小写，请注意" value="{{old('recommend_code')}}">
                    </div>

                    <input type="hidden" value="{{$phone}}" name="phone">
                    <input type="hidden" value="{{old('brand_id')}}" name="brand_id">
                    <input type="hidden" value="{{old('expect_id')}}" name="expect_id">
                    {{csrf_field()}}

                    {{--接收响应信息--}}
                    @include('wechat.layout.message')
                </form>
            </div>
        </div>
    </div>

    <div class="ui modal info">

    </div>

    <button id="user-submit" class="ui fluid green button absolute bottom">提交</button>
    </body>
    <script>
        //激活下拉菜单
        $('.ui.dropdown').dropdown();
        //激活手风琴式菜单
        $('.ui.accordion').accordion();

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





    </script>
@endsection