<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <title>Laravel</title>
</head>
<body>
<table>
    @php
        echo $tbody;
    @endphp

</table>
<div id="back" style="display: none;"></div>
</body>
<script>
    function getStr($string, $point) {
        return $string.slice($string.indexOf($point) + 1);
    }

    $.each($('tr:gt(0)'), function (index, item) {

        var data = {
            pid:getStr($(item).find('td:first>a').attr('href'), '='),
            image_url: $(item).find('img').attr('src'),
            name: $(item).find('td:eq(1)>p:first').text(),
            brand_id: getStr($(item).find('td:eq(1)>p>a').attr('href'), '='),
            brand: $(item).find('td:eq(1)>p>a').text(),
            packet_code: getStr($(item).find('td:eq(1)>p:eq(2)').text(), '：'),
            carton_code: getStr($(item).find('td:eq(1)>p:eq(3)').text(), '：'),
            type: $(item).find('td:eq(2)').text(),
            size: $(item).find('td:eq(3)').text(),
            price: parseInt($(item).find('td:eq(4)>span').text()),
            company: $(item).find('td:eq(5)').text()
        };
        $.get('{{url('fetch')}}', data,function (data) {
            $('#back').text(data).show();
        },'json');
    })
    ;
</script>
</html>
