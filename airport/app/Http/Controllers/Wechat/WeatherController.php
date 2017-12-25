<?php

namespace App\Http\Controllers\Wechat;

use App\Fetch\Snoopy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WeatherController extends Controller
{
    public function index()
    {
        return view('wechat.weather');
    }

    public function getWeather($code)
    {
        $url = 'http://wthrcdn.etouch.cn/weather_mini?citykey='.$code;
        $snoopy = new Snoopy();
        return $snoopy->fetch($url)->results;
    }
}
