<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>index</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="domain" content="{{ url('admin') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/semantic.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/font-yuren.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/swiper-3.4.2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/calendar.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/semantic.min.js')}}"></script>
    <script src="{{asset('js/jquery.yu.js')}}"></script>
    <script src="{{asset('js/swiper-3.4.2.min.js')}}"></script>
    <script src="{{asset('js/calendar.js')}}"></script>
    @include('UEditor::head')

</head>

@yield('content')

{{--以下js位置不能变，否则不执行--}}
<script src="{{asset('js/basic.js')}}"></script>
<script src="{{asset('js/admin.js')}}"></script>
</html>