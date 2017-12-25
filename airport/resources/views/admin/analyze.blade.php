@extends('admin.layout.analyze-frame')
@section('content')
    <body style="overflow: scroll;">
    <!--页面标题-->
    <div class="ui header p14">用户分析</div>
    <!--页面标题end-->
    <div class="ui container pb100 pt40">

        <div class="ui one column grid pb100">
            <div class="eight wide computer only sixteen wide tablet only mobile only column">
                <canvas id="canvas"></canvas>
            </div>
            <div class="eight wide computer only sixteen wide tablet only mobile only column">
                <canvas id="canvas2" style="height: 300px"></canvas>
            </div>
        </div>
        <a class="ui basic primary button"
           href="{{url('admin/resource/excel/analyze')}}">下载表格</a>
        <table class="ui unstackable striped table" id="shop-table">
            <thead>
            <tr>
                <th>时间</th>
                <th>新增关注人数</th>
                <th>取消关注人数</th>
                <th>净增关注人数</th>
                <th>累计关注人数</th>
            </tr>
            </thead>
            <tbody>
            @for($i =0;$i<10;$i++)
                <tr>
                    <td>2017-4-{{$i}}</td>
                    <td>5</td>
                    <td>1</td>
                    <td>4</td>
                    <td>385</td>
                </tr>
            @endfor
            </tbody>
        </table>
    </div>
    </body>
    <script>

    </script>
@endsection