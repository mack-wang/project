@extends('admin.layout.frame')
@section('content')
    <body class="iframe-body">
    <!--页面标题-->
    <div class="ui header p14">查看所有活动</div>
    <!--页面标题end-->


    <div class="ui grid pb100">

        <div class="column">
            <table class="ui unstackable striped table" id="shop-table">
                <thead>
                <tr>
                    <th>编号</th>
                    <th>类型</th>
                    <th class="two wide">标题</th>
                    <th>文章</th>
                    <th>卷烟</th>
                    <th>选择</th>
                    <th>开展时间</th>
                    <th>状态</th>
                    <th>编辑</th>
                    <th>查看</th>
                    <th>删除</th>
                </tr>
                </thead>
                <tbody>
                @foreach($activities as $activity)
                    <tr>
                        <td>
                            {{$activity->id}}
                        </td>
                        <td data-value="{{$activity->type}}">
                            {{\App\Helper::$typeArray[$activity->type]}}
                        </td>
                        <td>
                            {{$activity->activity_attrs->title   or '/'}}
                        </td>
                        <td>
                            {{$activity->articles->title  or '/'}}
                        </td>
                        <td>
                            {{$activity->fetch_cigarettes->name or '/'}}
                        </td>
                        <td>
                            @if($activity->elect === 0)
                                自动
                            @elseif($activity->elect === 2)
                                已选择
                            @else
                                人工
                            @endif
                        </td>
                        <td>
                            开始：{{$activity->start_at}}
                            <br>
                            结束：{{$activity->end_at}}
                        </td>
                        <td>
                            @if($activity->off === 0)
                                <div class="ui fitted checkbox activities">
                                    <input type="checkbox" checked="checked" value="{{$activity->id}}">
                                    <label></label>
                                </div>
                            @else
                                <div class="ui fitted checkbox activities">
                                    <input type="checkbox" value="{{$activity->id}}">
                                    <label></label>
                                </div>
                            @endif
                        </td>
                        <td><a class="listDetail"
                               href="{{url('admin/list/detail/'.$activity->type.'/'.$activity->id)}}">编辑</a></td>
                        <td>
                            @if($activity->type == "apply" || $activity->type == "kill")
                                <a class="listDetail"
                                   href="{{url('admin/list/view/apply/'.$activity->id)}}">查看</a>
                            @else
                                /
                            @endif

                        </td>
                        <td><a class="listDelete" onclick="return confirm('是否确定删除？')"
                               href="{{url('admin/list/delete/'.$activity->id)}}">删除</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $activities->links() }}
            @include('admin.layout.message')
        </div>

    </div>
    <!--页面标题end-->


    <div style="display: none;">
        <script id="container2" name="content2" type="text/plain"></script>
    </div>

    </body>
@endsection