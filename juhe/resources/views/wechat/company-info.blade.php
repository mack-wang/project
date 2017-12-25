@extends('wechat.layout.frame-swiper')
@section('content')
    <body class="m0p0" style="position: relative;">
    <div class="ui one column grid columns feeds">
        @if($company !== null)
            <div class="column">
                <div class="ui segment mt8 clear-border clear-shadow">
                    <div class="ui feed">
                        <div class="event">
                            <div class="content" style="padding: 6px 0 0 8px;">
                                <div class="summary">
                                    {{$company->company}}
                                </div>
                                <div class="meta">
                                    {{$company->industry}}
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
            <form class="ui form " action="{{url('wechat/company')}}" method="post">
                <div class="m8">
                    <div class="ui header">公司信息</div>
                    <div class="two fields">
                        <div class="eight field">
                            <input type="text" name="company"
                                   value="{{$company->company or ''}}" placeholder="公司名称">
                        </div>
                        <div class="eight wide  field">
                            <input type="text" name="industry"
                                   value="{{$company->industry or ''}}" placeholder="所属行业（例如：金融、电子商务等）">
                        </div>
                    </div>

                    <div class="field">
                        <label style="display: none;">企业规模</label>
                        <select name="size">
                            <option value="1">1-20人</option>
                            <option value="2">20-50人</option>
                            <option value="3">50-100人</option>
                            <option value="4">100人以上</option>
                        </select>
                    </div>
                    {{csrf_field()}}

                    {{--接收响应信息--}}
                    <input type="hidden" name="id" value="{{$company->id or ''}}">
                </div>



                <div class="m8">
                    @include('wechat.layout.message')
                </div>
                <div class="ui error message m8"></div>
            </form>
        </div>
    </div>
    <button class="ui fixed sticky bottom fluid blue button clear-radio submit" style="height: 50px;">{{ $company != null ? '修改' : '提交'}}</button>
    </body>
    <script>
        $('select>option[value={{$company->size or 1}}]').attr('selected', 'selected');
        $('.submit').click(function () {
            $('form').submit();
        })
    </script>
@endsection