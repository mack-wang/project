@extends('admin.layout.frame')
@section('content')
    <body class="iframe-body">

    <!--页面标题-->
    <div class="ui header p14">批量添加终端</div>
    <!--页面标题end-->
<div class="ui grid m28">
    <form action="{{url('admin/shop/upload')}}" method="POST" enctype="multipart/form-data">
        <a class="ui basic primary button"
           href="{{url('admin/resource/excel/shops_template')}}">下载店铺模板表格</a>
        {{csrf_field()}}
        <div class="ui center aligned segment pv50">
            <div class="ui disabled lighter header"><i class="yu-location-arrow icon"></i>请将店铺表格拖至此处</div>
            <div class="ui horizontal divider">或</div>
            <button class="ui primary button">
                上传店铺表格 <i class="yu-angle-right icon"></i>
            </button>
        </div>
    </form>
</div>

    <div style="height: 200px;"></div>
    <script>
        //启动dropdown
        $('.ui.dropdown').dropdown();

        //启动手风琴式菜单
        $('.ui.accordion').accordion();

        //启动标签式菜单
        $('.menu .item').tab();
    </script>
    </body>
@endsection