@extends('wechat.layout.frame-home')
@section('content')
    <div>
        <div class="ui container">
            <div class="ui fluid mini category search article"
                 style="position: absolute;top: 10px;left: 20%;width: 60%;z-index: 2;">
                <div class="ui icon input" style="width: 100%;opacity: 0.8">
                    <input class="prompt" type="text" placeholder="搜索团购产品">
                    <i class="search icon"></i>
                </div>
                <div class="results"></div>
            </div>
        </div>

        <div style="position: absolute;top: 18px;right: 3%;z-index: 2;">
            <a href="{{url('home')}}" style="color: white;">
                {{ Auth::check() ? "个人中心" : "登入" }}
            </a>
        </div>
    </div>

    <div class="ui one column grid mb50">
        {{--轮播图--}}
        <div class="column">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($navs as $nav)
                        <div class="swiper-slide">
                            <a href="{{$nav->redirect_path == null ? url('wechat/article/'.$nav->article_id) : url($nav->redirect_path)}}">
                                <img class="ui image fullwidth" src="{{asset($nav->image_path)}}" alt="">
                            </a>
                        </div>
                    @endforeach

                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        {{--轮播图end--}}

        <div class="column p0">
            <div class="ui center aligned five column grid nav">
                <div class="column">
                    <a href="{{url('wechat/catalog/1')}}" class="item">
                        <i class="big orange yu-oil icon"></i>
                        <div>油</div>
                    </a>
                </div>
                <div class="column">
                    <a href="{{url('wechat/catalog/2')}}" class="item">
                        <i class="big green yu-rice icon"></i>
                        <div>米</div>
                    </a>
                </div>
                <div class="column">
                    <a href="{{url('wechat/catalog/3')}}" class="item">
                        <i class="big blue yu-flour icon"></i>
                        <div>面粉</div>
                    </a>
                </div>
                <div class="column">
                    <a href="{{url('wechat/catalog/4')}}" class="item">
                        <i class="big teal yu-noodle icon"></i>
                        <div>挂面</div>
                    </a>
                </div>
                <div class="column">
                    <a href="{{url('wechat/catalog/5')}}" class="item">
                        <i class="big orange yu-seasoner icon"></i>
                        <div>调味品</div>
                    </a>
                </div>
                <div class="column">
                    <a href="{{url('wechat/catalog/6')}}" class="item">
                        <i class="big green yu-drink icon"></i>
                        <div>食品饮品</div>
                    </a>
                </div>
                <div class="column">
                    <a href="{{url('wechat/catalog/7')}}" class="item">
                        <i class="big blue yu-globalBuy icon"></i>
                        <div>全球优品</div>
                    </a>
                </div>
                <div class="column">
                    <a href="{{url('wechat/catalog/8')}}" class="item">
                        <i class="big orange yu-popcorn icon"></i>
                        <div>休闲食品</div>
                    </a>
                </div>
                <div class="column">
                    <a href="{{url('wechat/catalog/9')}}" class="item">
                        <i class="big red yu-washing icon"></i>
                        <div>日化</div>
                    </a>
                </div>
                <div class="column">
                    <a href="{{url('wechat/product')}}" class="item">
                        <i class="big blue yu-ellipsis icon"></i>
                        <div>更多</div>
                    </a>
                </div>
            </div>
        </div>

        <div class="column divider"></div>

        {{--钜合公告消息--}}
        <div class="column p0">
            <div class="ui container pv05ph1">
                <div style="display: inline-block;padding-top: 2px;">
                    钜合 <label for="" class="ui tiny left pointing red label">头条</label>
                </div>
                <div style="display: inline-block;vertical-align: middle">
                    @foreach($headlines as $headline)
                        <a href="{{$headline->article_id ? url('wechat/article/'.$headline->article_id) : "#"}}"
                           class="ph4 headlineNode fl" data-value="{{$headline->id or ''}}">
                            {{str_limit($headline->headline,28)}}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        @foreach($catalogs as $catalog)
            <div class="column divider"></div>

            {{--钜合推荐信息--}}
            <div class="column p0">
                <div class="ui container pv05ph1">
                    {{$catalog->catalog}}
                    <div class="ui divider m0"></div>
                </div>
                <div class="ui container pv05ph1">
                    <div class="ui tow column grid ph14 mb4">
                        @foreach($catalog->articles()->orderBy('top','desc')->get() as $article)
                            <div class="row p0 mt4">
                                <a href="{{url('wechat/article/'.$article->id)}}" class="four wide column p0">
                                    <img class="ui tiny image" src="{{asset($article->image)}}" alt="">
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
                </div>
            </div>
        @endforeach
    </div>
@endsection