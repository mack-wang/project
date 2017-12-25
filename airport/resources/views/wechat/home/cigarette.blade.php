@extends('wechat.layout.frame')
@section('content')
    <body>
    <form id="searchByName" action="{{url('wechat/login/searchByName')}}" method="get">
        <div class="ui fluid search">
            <div class="ui fluid  icon input m8">
                <input class="prompt" type="text" name="cigarette" placeholder="搜索卷烟品牌名" value="{{old('cigarette')}}">
                <i class="search icon"></i>
            </div>
            <div class="results"></div>
        </div>
    </form>
    <div class="ui celled list">
        @foreach($cigarettes as $cigarette)
            <div class="item">
                <div class="content" style="height: 30px;line-height: 30px;padding-left: 16px;">
                    <div class="ui checked checkbox">
                        <input type="checkbox" name="brand">
                        <label>{{$cigarette->cigarette}}</label>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $cigarettes->links() }}

    <button id="user-submit" class="ui fluid green button absolute bottom">保存</button>
    </body>
    <script>
        //激活下拉菜单
        $('.ui.dropdown').dropdown();
        //激活手风琴式菜单
        $('.ui.accordion').accordion();

        $('.ui.search')
                .search({
                    apiSettings: {
                        url: '/wechat/login/search?cigarette={query}',
                        onResponse: function (data) {
                            var content = [];
                            $.each(data, function (index, item) {
                                if (index > 4) {
                                    return false;
                                }
                                content.push({title: item['cigarette']});
                            });
                            return {
                                results: content
                            };
                        }
                    },
                    minCharacters: 2,
                    type: 'standard',
                    onSelect: function () {
                        $('#searchByName').submit();
                    }
                })
        ;

        //        $('.your.element')

        //semantic搜索一定要组织成以下这样的对象形式，results是搜索结果，title是搜索结果的标题，url是搜索要跳转的链接
        //        {
        //            "results": [
        //            {
        //                "title": "Result Title",
        //                "url": "/optional/url/on/click",
        //                "image": "optional-image.jpg",
        //                "price": "Optional Price",
        //                "description": "Optional Description"
        //            },
        //            {
        //                "title": "Result Title",
        //                "description": "Result Description"
        //            }
        //        ],
        //                // optional action below results
        //                "action": {
        //            "url": '/path/to/results',
        //                    "text": "View all 202 results"
        //        }
        //        }


    </script>
@endsection