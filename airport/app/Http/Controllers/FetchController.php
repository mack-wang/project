<?php

namespace App\Http\Controllers;

use App\Fetch\Snoopy;
use App\Models\FetchCigarette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp;

class FetchController extends Snoopy
{
    public function test($page)
    {
        $url = 'http://www.etmoc.com/market/Brandlist.asp?page=' . $page . '&worded=&temp=';
        $result = Snoopy::fetch($url);

        $result2 = iconv("GB2312", "UTF-8//IGNORE", $result->results);


        preg_match("/<tbody.*?>(.*?)<\/tbody>/is", $result2, $match);

        $tbody = $match[0];
        $tbody = str_replace("../firm/", "http://www.etmoc.com/firm/", $tbody);
//        dd($tbody);

        return view('test', [
            'tbody' => $tbody
        ]);
    }

    public function update(Request $request)
    {
        DB::table('fetch_cigarettes')->insert($request->all());
        return '成功';
    }

    public function getImages()
    {
        FetchCigarette::get(['pid', 'image_url'])->each(function ($item, $key) {
            $client = new GuzzleHttp\Client();
            ends_with($item->image_url, 'jpg') ? $end = '.jpg': $end = '.png';
            $image_path = 'app/store/' . date('Ymd') . $item->pid . $end;
            $client->get($item->image_url, ['save_to' => storage_path($image_path)]);  //保存远程url到文件
            DB::table('fetch_cigarette_images')->insert([
                'pid' => $item->pid,
                'image_path' => $image_path,
            ]);
        });
    }
}