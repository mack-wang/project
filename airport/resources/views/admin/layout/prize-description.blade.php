{{--奖品描述--}}
<div class="column">
    <div class="ui two column grid prize-describe">
        @if($activity->fetch_cigarettes->status === 0)
            <div class="column">名称：{{$activity->fetch_cigarettes->name}}</div>
            <div class="column">品牌：{{$activity->fetch_cigarettes->brand}}</div>
            <div class="column">类型：{{$activity->fetch_cigarettes->type}}</div>
            <div class="column">尺寸：{{$activity->fetch_cigarettes->size}}</div>
            <div class="column">市场价：{{$activity->fetch_cigarettes->price}}元/条</div>
            <div class="column">企业：{{str_limit($activity->fetch_cigarettes->company,16)}}</div>
            @foreach(str_getcsv($activity->activity_prizes->description) as $describe)
                <div class="column">{{$describe}}</div>
            @endforeach
        @else
            <div class="column">名称：{{$activity->fetch_cigarettes->name}}</div>
            <div class="column">品牌：{{$activity->fetch_cigarettes->brand}}</div>
            <div class="column">市场价：{{$activity->fetch_cigarettes->price."元"}}</div>
            @foreach(str_getcsv($activity->activity_prizes->description) as $describe)
                <div class="column">{{$describe}}</div>
            @endforeach
        @endif
    </div>
</div>
{{--奖品描述end--}}