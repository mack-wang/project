@extends('wechat.layout.frame-home')
@section('content')
    <div class="ui center text container p14">
        <div class="ui fluid mini category search article">
            <div class="ui icon input" style="width:100%;opacity: 0.8">
                <input class="prompt" type="text" placeholder="搜索团购产品">
                <i class="search icon"></i>
            </div>
            <div class="results"></div>
        </div>
    </div>

    <div class="ui one column grid mb50">
        <div class="column p0" style="overflow-y: auto;">
            <div class="ui container">
                <div class="ui secondary product menu p8">
                    @foreach($menus as $menu)
                        <a class="item" href="{{url('wechat/catalog/'.$menu->id)}}">
                            {{$menu->catalog}}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        @foreach($catalogs as $catalog)
            <div class="column divider"></div>

            {{--精选粮油模块--}}
            <div class="column p0">
                <div class="ui container pv05ph1 mb8" style="font-weight: bold;">
                    {{$catalog->catalog}}
                </div>
                <div class="ui container pv05ph1">
                    <div class="ui two column product grid ph14 mb4">
                        @foreach($catalog->articles()->orderBy('top','desc')->take(3)->get() as $article)
                            <div class="row" style="border-top: #eee solid 1px;">
                                <a href="{{url('wechat/article/'.$article->id)}}" class="four wide column p0">
                                    <img class="ui w60 image" src="{{asset($article->image)}}" alt="">
                                </a>
                                <div class="twelve wide column p4">
                                    <a class="mb4" href="{{url('wechat/article/'.$article->id)}}">
                                        {{$article->title}}
                                    </a>
                                    <div class="ui description light text">
                                        {{$article->brief}}
                                    </div>
                                    <div class="ui description light text">
                                        品牌：{{$article->brand}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="ui divider m0"></div>
                    <div class="text-center m8">
                        <a class="light text" href="{{url('wechat/catalog/'.$catalog->id)}}">
                            更多 <i class="ui angle right icon"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="column p0">
            <div class="ui divider m0"></div>
            <div class="ui center aligned container pv05ph1 mb8" style="font-weight: bold;">
                {{$catalogs->links()}}
            </div>
        </div>
    </div>
@endsection