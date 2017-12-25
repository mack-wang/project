@extends('wechat.layout.frame')
@section('content')
    <body>
    <img src="{{asset('img/airport/header.png')}}" class="fullwidth" alt="">
    <div class="ui one column grid columns">
        {{--活动内容--}}
        <div class="column">
            <div class="ui small header">
                出租车等候处
            </div>
            <div>
                <img class="fullwidth" src="{{asset('img/airport/taxi.jpg')}}" alt="">
                机场旅客出租车上客处位于国内航站楼到达层10号门外，每天约有3000辆出租车投入运营，旅客打车十分便利。
            </div>
        </div>
        <div class="column">
            <div class="ui small header">
                杭州出租车收费标准
            </div>
            <div>
                <p>普通出租车：起步价为11元/3公里；行驶里程3-10公里每公里租费由2元调整为2.5元，超过10公里以上的部分加收50%的回空补贴费（即每公里3.75元）；因路阻及乘客要求临时停车的，由5分钟按1公里租费调整为4分钟按1公里租费计收（即等候4分钟按2.5元计收）。电动出租车按普通客运出租车运价执行。
                </p>
                <p>
                豪华出租车（代表车型奔驰）：起步价为11元/2公里，行驶里程2-8公里每公里租费由3元调整为3.6元，超过8公里的部分加收50%的回空补贴费；因路阻及乘客要求临时停车的，每4分钟按1公里租费计收。
                </p>
            </div>
        </div>
        <div class="column">
            <div class="ui small header">
                旅客注意事项
            </div>
            <div>
                <div class="ui bulleted list">
                    <div class="item">保管好随身携带的行李物品；</div>
                    <div class="item">按计价器显示金额付费，不议价；</div>
                    <div class="item">保护自身合法权益，拒绝拼载；</div>
                    <div class="item">如发生出租车司机中途甩客，旅客有权拒绝付费；</div>
                    <div class="item">严禁车内吸烟，如发生出租车司机开车吸烟的情况，旅客有权拒绝付费；</div>
                    <div class="item">索要发票；</div>
                    <div class="item">保持车内清洁、卫生，不要污损车容。</div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="ui small header">
                出租车等候处
            </div>
            <div>
                机场旅客出租车上客处位于国内航站楼到达层10号门外，每天约有3000辆出租车投入运营，旅客打车十分便利。
            </div>
        </div>
        <div class="column">
            <div class="ui small header">
                机场周边交通图
            </div>
            <div>
                <img class="fullwidth" src="{{asset('img/airport/map.jpg')}}" alt="">
            </div>
        </div>
        <div class="column">
            <div class="ui small header">
                机场巴士
            </div>
            <div>
                机场巴士候车室位于机场候机楼到达厅8号门

                <div class="ui bulleted list">
                    <div class="item">武林门线</div>
                    <div class="item">平海路（城站火车站）线</div>
                    <div class="item">火车东站专线</div>
                    <div class="item">滨江线</div>
                    <div class="item">下沙线</div>
                    <div class="item">余杭、未来科技城专线</div>
                    <div class="item">望湖、西溪湿地</div>
                    <div class="item">杭钢专线</div>
                    <div class="item">温州专线</div>
                    <div class="item">临安</div>
                    <div class="item">汽车北站（九堡客运中心）专线</div>
                    <div class="item">汽车南站线</div>
                    <div class="item">汽车西站线</div>
                    <div class="item">萧山城区</div>
                    <div class="item">绍兴、柯桥</div>
                    <div class="item">义乌</div>
                    <div class="item">青田</div>
                    <div class="item">东阳横店</div>
                    <div class="item">湖州、武康</div>
                    <div class="item">嵊州</div>
                    <div class="item">嘉兴</div>
                    <div class="item">海宁</div>
                    <div class="item">永康</div>
                    <div class="item">台州（椒江、路桥、黄岩）</div>
                    <div class="item">乌镇(桐乡)</div>
                    <div class="item">安吉</div>
                    <div class="item">上虞</div>
                    <div class="item">临平</div>
                    <div class="item">衢州</div>
                    <div class="item">临海</div>
                    <div class="item">丽水</div>
                    <div class="item">舟山沈家门</div>
                    <div class="item">千岛湖</div>
                    <div class="item">富阳</div>
                    <div class="item">浦江</div>
                    <div class="item">温岭</div>
                    <div class="item">桐庐</div>
                    <div class="item">仙居</div>
                    <div class="item">濮院（桐乡）专线</div>
                    <div class="item">平湖、海盐专线</div>
                    <div class="item">新安江</div>
                </div>
            </div>

        </div>

        {{--活动内容end--}}
    </div>
    <div class="ui sticky fixed  bottom" style="width: 100%;">
        <div class="ui huge circular label fr m28 backButton" onclick="history.go(-1)" style="opacity: 0.8;">
            <i class="ui white chevron left icon p0m0"></i>
        </div>
    </div>
    </body>
@endsection