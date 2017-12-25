@extends('wechat.layout.frame-swiper')
@section('content')
    <body class="m0p0" style="position: relative;">
    <div class="ui one column grid columns feeds">
        @if($address !== null)
            <div class="column">
                <div class="ui segment mt8 clear-border clear-shadow">
                    <div class="ui feed">
                        <div class="event">
                            <div class="content" style="padding: 6px 0 0 8px;">
                                <div class="summary">
                                    {{$address->real_name}} {{$address->mail_phone}}
                                </div>
                                <div class="meta">
                                    {{$address_str}}
                                </div>
                            </div>
                            <a href="{{url('home')}}" class="feeds button" style="line-height: 50px;">
                                返回
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="column divider"></div>
        <div class="column">
            <form id="update-address" class="ui form " action="{{url('wechat/address')}}" method="post">
                <div class="m8">
                    <div class="ui header">邮寄信息</div>
                    <div class="two fields">
                        <div class="eight field">
                            <input type="text" name="real_name" placeholder="姓名">
                        </div>
                        <div class="eight wide  field">
                            <input type="text" name="mail_phone" placeholder="手机号">
                        </div>
                    </div>

                    <div class="three fields">
                        <div class="field">
                            <label style="display: none;">省份</label>
                            <select name="province" id="province">
                                <option value="">省份</option>
                            </select>
                        </div>
                        <div class="field">
                            <label style="display: none;">市区</label>
                            <select name="city" id="city">
                                <option value="">市区</option>
                            </select>
                        </div>
                        <div class="field">
                            <label style="display: none;">街道</label>
                            <select name="area" id="area">
                                <option value="">街道</option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <input type="text" name="address" placeholder="具体地址，至少2个字">
                    </div>
                    {{csrf_field()}}

                    {{--接收响应信息--}}
                    <input type="hidden" name="id" value="{{$address->id or ''}}">
                </div>


                <div class="m8">
                    @include('wechat.layout.message')
                </div>
                <div class="ui error message m8"></div>
            </form>
        </div>
    </div>
    <button class="ui fixed sticky bottom fluid blue button clear-radio submit" style="height: 50px;">{{ $address != null ? '修改' : '提交'}}</button>
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

        //邮寄城市地址显示


        $('#province').on('change', function () {
            var pid = $('#province>option:selected').val();
            $.get('{{url('wechat/search/city').'/'}}' + pid, function (data) {
                $city = $('#city');
                $city.find('option:gt(0)').remove();
                $.each(data, function (index, item) {
                    var option = '<option value="' +
                        item['id'] +
                        '">' +
                        item['name'] +
                        '</option>';
                    $city.append(option);
                });
            }, 'json');
        });

        $('#city').on('change', function () {
            var pid = $('#city>option:selected').val();
            $.get('{{url('wechat/search/city').'/'}}' + pid, function (data) {
                $area = $('#area');
                $area.find('option:gt(0)').remove();
                $.each(data, function (index, item) {
                    var option = '<option value="' +
                        item['id'] +
                        '">' +
                        item['name'] +
                        '</option>';
                    $area.append(option);
                })
            }, 'json');
        });

        $('.submit').click(function () {
            $('form').submit();
        })
    </script>
@endsection