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

    {{--精选粮油模块--}}
    <div class="column p0">
        <div class="ui container pv05ph1 mb8" style="font-weight: bold;">
        </div>
        <div class="ui container">
            <div class="ui two column product grid mb4">
                @foreach($articles as $article)
                    <div class="row p0" style="border-top: #eee solid 1px;">
                        <a class="four wide column p0" href="{{url('wechat/article/'.$article->id)}}">
                            <img class="ui tiny image m8" src="{{asset($article->image)}}" alt="">
                        </a>
                        <div class="twelve wide column p8">
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
        </div>
        <div class="ui divider m0"></div>
        <div class="text-center m8">
            {{$articles->links()}}
        </div>
    </div>
@endsection