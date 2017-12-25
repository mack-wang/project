@extends('wechat.layout.frame-chart')
@section('content')
    <body>
    <div class="ui one column grid columns feeds">
        {{--活动内容--}}
        <div class="column"
             style="background: url('{{asset('img/weather-bg.png')}}') no-repeat;background-size:100% 100%;color:white">

            <div class="ui segment border-clear" style="background-color: transparent;margin-top: 20px;">
                <div class="m8" id="timeArea">
                    <span>{{\App\Helper::chineseDate()}}</span>
                    <span class="fr"><i class="ui yu-location icon"></i><span class="city"></span></span>
                </div>
                <div class="text-center pt40" id="currentCity">

                </div>

                <div id="weather" class="ui five column grid">
                </div>
                <div class="center-block mt20" style="width: 94%">
                    <canvas id="myChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        {{--活动内容end--}}
        <div class="column">
            <div class="ui segment border-clear">
                <div class="text-center fullwidth pt20">
                    <div class="ui icon input" style="width: 80%">
                        <input id="searchWeather" type="text" placeholder="查询天气...">
                        <i class="inverted circular search link icon"></i>
                    </div>
                </div>

                <div class="ui segment clear-shadow border-clear mt0 weather">
                    <a>北京</a>
                    <a>上海</a>
                    <a>广州</a>
                    <a>深圳</a>
                    <a>云南</a>
                    <a>重庆</a>
                    <a>杭州</a>
                </div>
            </div>

        </div>
    </div>
    <div class="ui sticky fixed  bottom" style="width: 100%;">
        <div class="ui huge circular label fr m28 backButton" onclick="history.go(-1)" style="opacity: 0.8;">
            <i class="ui white chevron left icon p0m0"></i>
        </div>
    </div>
    </body>
    <script src="{{asset('js/Chart.min.js')}}"></script>
    <script src="{{asset('js/Chart.bundle.min.js')}}"></script>
    <script>
        window.chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(231,233,237)'
        };

        window.randomScalingFactor = function () {
            return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
        }
    </script>
    <script>
        $('.weather>a').click(function (e) {
            $('#searchWeather').val($(this).text());
            $('i.search.icon').click();
        });

        getWeather(101210101);

        $("i.search.icon").click(function (e) {
            var city = $(this).prev().val();
            if (city.length === 0) {
                alert("您未输入任何地址");
                return false;
            }

            $.ajax({
                url: "{{asset('js/city.xml')}}",
                dataType: 'xml',
                type: 'GET',
                timeout: 2000,
                error: function (xml) {
                    alert("加载XML 文件出错！");
                },
                success: function (xml) {
                    var code = $(xml).find("d[d4=" + city + "]").first().attr('d1');
                    if (!code) {
                        code = $(xml).find("d[d2=" + city + "]").first().attr('d1');
                        if (!code) {
                            alert("未查询出您搜索的地点天气");
                            return false;
                        }
                    }
                    getWeather(code);
                }
            })
        });

        function getWeather(code) {
            $.ajax({
                url: "{{url('wechat/weather/get')}}" + "/" + code,
                dataType: 'json',
                type: 'GET',
                timeout: 2000,
                error: function (weather) {
                    alert("查询错误！");
                },
                success: function (weather) {
                    if (weather.status !== 1000) {
                        alert('未查询到当地天气');
                        return false;
                    }

                    var $weather = $("#weather").empty();
                    var $currentCity = $("#currentCity").empty();
                    var low = [], high = [];

                    $('.city').text(weather.data.city);
                    $currentCity.append(
                        '<div style="font-size: 50px;margin-bottom: 20px">' + weather.data.wendu + '°</div>' +
                        '<div class="m8 text-center">' +
                        '<span>' + weather.data.forecast[0].type + ' </span>' +
                        '<span>' +
                        weather.data.forecast[0].fengli + weather.data.forecast[0].fengxiang +
                        ' </span>' +
                        '<span>' +
                        parseInt(weather.data.forecast[0].low.substr(3)) + '°~' +
                        parseInt(weather.data.forecast[0].high.substr(3)) + '°' +
                        '</span>' +
                        '<div class="center-block" style="font-size: 12px;opacity: 0.4;margin-top: 10px;width: 80%;">温馨提示：' +
                        weather.data.ganmao +
                        '</div>' +
                        '</div>'
                    );
                    $.each(weather.data.forecast, function (index, item) {
                        var row = '<div class="column text-center p0 f12">' + item.date.replace("星", "<br>星") + '<br>' + item.type + '</div>';
                        low.push(parseInt(item.low.substr(3)));
                        high.push(parseInt(item.high.substr(3)));
                        $weather.append(row);
                    });
                    var ctx = document.getElementById("myChart").getContext("2d");

                    var config = {
                        type: 'line',
                        data: {
                            labels: ["", "", "", "", "    "],
                            datasets: [{
                                backgroundColor: 'rgb(255, 255,255)',
                                borderColor: 'rgb(255, 255,255)',
                                data: high,

                                fill: false
                            }, {
                                fill: false,
                                backgroundColor: 'rgb(255, 255,255)',
                                borderColor: 'rgb(255, 255,255)',
                                data: low
                            }]
                        },
                        options: {
                            responsive: true,
                            legend: {
                                display: false
                            },
                            scales: {
                                xAxes: [{
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    }
                                }],
                                yAxes: [{
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    }

                                }]
                            },
                            animation: {
                                duration: 1,
                                onComplete: function () {
                                    var ctx = this.chart.ctx;
                                    ctx.font = Chart.helpers.fontString(
                                        Chart.defaults.global.defaultFontFamily,
                                        'normal',
                                        Chart.defaults.global.defaultFontFamily
                                    );
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'bottom';

                                    this.data.datasets.forEach(function (dataset) {
                                        for (var i = 0; i < dataset.data.length; i++) {
                                            var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                                scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
                                            ctx.fillStyle = '#fff';
                                            var y_pos = model.y - 5;
                                            if ((scale_max - model.y) / scale_max >= 0.93)
                                                y_pos = model.y + 20;
                                            ctx.fillText(dataset.data[i] + "°", model.x, y_pos);
                                        }
                                    });
                                }
                            }
                        }
                    };

                    new Chart(ctx, config);
                }
            })
        }

    </script>
@endsection