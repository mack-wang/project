<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>index</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="domain" content="{{ url('admin') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/semantic.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/font-yuren.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/semantic.min.js')}}"></script>
    <script src="{{asset('js/jquery.yu.js')}}"></script>
</head>

@yield('content')

{{--以下js位置不能变，否则不执行--}}
<script src="{{asset('js/Chart.min.js')}}"></script>
<script src="{{asset('js/Chart.bundle.min.js')}}"></script>
<script src="{{asset('js/adminChart.js')}}"></script>
</html>