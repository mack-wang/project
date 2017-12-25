<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>钜合天下</title>
    <meta name="domain" content="{{ url('wechat') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/semantic.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('font/juhe/juhe.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/basic.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/swiper-3.4.2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/semantic.min.js')}}"></script>
    <script src="{{asset('js/jquery.yu.js')}}"></script>
    <script src="{{asset('js/swiper-3.4.2.min.js')}}"></script>
</head>

@yield('content')

{{--以下js位置不能变，否则不执行--}}
<script src="{{asset('js/basic.js')}}"></script>
<script src="{{asset('js/wechat.js')}}"></script>
</html>