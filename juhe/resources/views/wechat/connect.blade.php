@extends('wechat.layout.frame-home')
@section('content')
    <div class="connect mb50">
        <div class="ui fluid card clear-border clear-shadow clear-radio">
            <div class="image">
                <img src="{{asset($contact->image)}}" class="clear-radio">
            </div>
            <div class="content">
                <a class="header">{{$contact->phone}}</a>
                <a class="header">
                    {{$contact->time}}
                </a>
                <div class="description">
                    {{$contact->content}}
                </div>
                <div class="ui center aligned" style="margin-top: 50px;">
                    <a class="ui huge green circular icon button" href="tel:{{$contact->phone}}">
                        <i class="large phone icon"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection