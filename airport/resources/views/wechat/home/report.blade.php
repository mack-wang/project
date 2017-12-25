@extends('wechat.layout.frame-slide',['title' => "填写测评报告"])
@section('content')
    <body class="m0p0" style="position: relative;">
    <div class="ui one column grid columns feeds">
        {{--轮播图--}}
        <div class="column">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach(str_getcsv($activity->activity_headimgs->image_path) as $image_path)
                        <div class="swiper-slide">
                            <img class="ui image slide" src="{{asset($image_path)}}" alt="">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        {{--轮播图end--}}

        {{--活动标题--}}
        <div class="column">
            <div class="ui segment">
                <div class="ui small lighter header p8">
                    <i class="red yu-fire icon p0m0"></i>
                    {{$activity->activity_attrs->title}}
                </div>
            </div>
        </div>
        {{--活动标题end--}}


        {{--奖品描述--}}
        @include("admin.layout.prize-description")
        {{--奖品描述end--}}

        <div class="column">
            <div class="ui  segment mt8">
                <h3 class="ui center aligned header mt8">填写评价报告</h3>
                <form id="reportForm" class="ui form m8" action="{{url('wechat/report/form')}}" method="post"
                      enctype="multipart/form-data">
                    <div class="field">
                        <label>对试用产品打分</label>
                        <div class="ui heart rating report" data-rating="0"></div>
                    </div>

                    <div class="field">
                        <label>填写体验感受(至少20字)</label>
                        <textarea rows="3" name="smoke"></textarea>
                    </div>

                    <div class="field" style="margin-bottom: 30px;">
                        <label>上传试用产品照片</label>
                        <!--活动轮播图模块-->
                        <div class="ui bottom  attached segment">
                            <div id="headimg_box" class="ui three special cards headimg_box" data-limit="9">
                            </div>
                            <div class="ui hidden divider"></div>
                            <div id="headimg_add" class="ui big basic icon button">
                                <i class="ui icon add"></i>
                            </div>
                            <div id="headimg_minus" class="ui big basic button">
                                清空
                            </div>
                        </div>
                        <input id="reportImages" type="file" name="images[]" style="display: none;" multiple
                               accept="image/gif,image/jpeg,image/jpg,image/png,image/svg" placeholder="上传试用产品照片">
                    </div>
                    <div class="text-center">
                        <div class="ui error message"></div>
                        @include('wechat.layout.message')
                        <button class="ui centered green button submit">提交</button>
                    </div>

                    {{csrf_field()}}
                    <input type="hidden" name="scores" placeholder="对试用产品打分">
                    <input type="hidden" name="activity_id" value="{{$activity->id}}">

                    {{--接收响应信息--}}

                </form>
            </div>
        </div>
    </div>

    </body>
    <script>

        $('.ui.rating')
            .rating({
                initialRating: 0,
                maxRating: 5
            })
        ;

        $('.ui.rating').rating({
            onRate:function (value) {
                $("#reportForm").form('set value','scores',value);
            }
        });
        var mySwiper = new Swiper('.swiper-container', {
            autoplay: 5000,
            speed: 1000,
            direction: 'horizontal',
            loop: true,
            pagination: '.swiper-pagination',
            paginationType: 'bullets'
        });

        $("#headimg_add").click(function () {
            $("#reportImages").click();
        });

        $("#headimg_minus").click(function () {
            $("#headimg_box").empty();
            var input = $("input[name=images]").val("");
        });



    </script>
@endsection