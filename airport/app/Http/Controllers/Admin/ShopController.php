<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopFormRequest;
use App\Models\Shop;
use App\Models\ShopArea;
use App\Models\ShopAttr;
use EasyWeChat\Foundation\Application;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ShopController extends Controller
{
    public $shop = [
        'name',
        'phone',
        'shopType',
        'cigarette_id',
        'area_id'
    ];

    public $attr = [
        'type',
        'level',
        'scores',
        'black'
    ];

    //显示所有店铺
    public function index()
    {
        $shops = Shop::with('shop_attrs', 'shop_areas')
            ->paginate(Helper::page());
        return view('admin.shop', ['shops' => $shops]);
    }

    //根据搜索的参数，来显示所有店铺
    public function search($key, $value)
    {
        //根据地区，返回店铺
        $shops = $this->searchKey($key, $value)
            ->with('shop_attrs', 'shop_areas')
            ->paginate(Helper::page());
        return view('admin.shop', [
            'shops' => $shops,
            'key' => $key,
            'value' => $value
        ]);
    }

    public function searchKey($key, $value)
    {
        switch ($key) {
            case 'type':
                return Shop::whereHas('shop_attrs', function ($query) use ($value) {
                    $query->where('type', '=', $value);
                });
            case 'name':
                return Shop::where('name', 'like', "%$value%");
            default :
                return Shop::where($key, $value);
        }
    }

    //根据当前页面显示的店铺，下载excel表格
    public function excel($key = null, $value = null)
    {
        //根据地区，返回店铺
        Excel::create($value . '店铺表格' . date("Y-m-d"), function ($excel) use ($key, $value) {

            $excel->sheet('Sheetname', function ($sheet) use ($key, $value) {

                if ($key == null) {
                    $shops = Shop::with('shop_attrs', 'shop_areas')->get()->toArray();
                } else {
                    $shops = $this->searchKey($key, $value)->with('shop_attrs', 'shop_areas')->get()->toArray();
                }

                $data = [];

                $title = [
                    '店铺编号',
                    '店铺名',
                    '所在地区',
                    '店主手机号',
                    '烟草证号',
                    '店铺终端类型',
                    '店铺类型',
                    '店铺等级',
                    '店铺积分',
                    '黑名单',
                    '创建时间',
                    '更新时间',
                ];

                foreach ($shops as $shop) {
                    array_push($data, [
                        $shop['id'],
                        $shop['name'],
                        $shop['shop_areas']['area'],
                        $shop['phone'],
                        $shop['cigarette_id'],
                        $shop['type'],
                        $shop['shop_attrs']['type'],
                        $shop['shop_attrs']['level'],
                        $shop['shop_attrs']['scores'],
                        $shop['shop_attrs']['black'],
                        $shop['created_at'],
                        $shop['updated_at'],
                    ]);
                }

                $sheet->appendRow($title);
                $sheet->rows($data);
            });
        })->download('xls');

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    //上传店铺
    public function store(ShopFormRequest $request)
    {
        try {
            Shop::create([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'type'=>$request->shopType,
                'cigarette_id'=>$request->cigarette_id,
                'area_id'=>$request->area_id,
            ])
                ->shop_attrs()
                ->create($request->only($this->attr));
            return back()->with('success', '新店铺上传成功');
        } catch (Exception $e) {
            return back()->with('error', '店铺上传失败,店铺名重复!')
                ->withInput();
        }
    }

    //通过表格批量上传店铺
    public function storeExcel(Request $request)
    {
        if (!$request->file('excel')->isValid()) {
            Session::flash('error', '上传出错');
        }

        if ($request->hasFile('excel')) {
            Excel::load($request->excel, function ($reader) {

                $shops = $reader->get()->toArray();

                //该函数是删除第0个位置起的，2项，并返回删除的项，直接改变变量
                array_splice($shops, 0, 2);

                $num = 0;

                foreach ($shops as $shop) {

                    try {
                        $shop['area_id'] = (ShopArea::where('area', $shop['area'])->pluck('id'))[0];
                        Shop::create([
                            'name'=>$shop['name'],
                            'phone'=>$shop['phone'],
                            'type'=>$shop['shoptype'],
                            'cigarette_id'=>$shop['cigarette_id'],
                            'area_id'=>$shop['area_id'],
                        ])
                            ->shop_attrs()->create(array_only($shop, $this->attr));
                    } catch (Exception $e) {
                        $num++;
                        Session::flash('error', $shop['name'] . "等共 $num 家店上传出错，请检查是否有重复!");
                    }
                };

                if (!session('error')) {
                    Session::flash('success', '表格上传成功,所有店铺批量创建成功！');
                }
            });
        } else {
            Session::flash('error', '表格上传失败');
        }

        return back();
    }


    //修改和更新店铺信息
    public function update(ShopFormRequest $request, $id)
    {
        try {
            Shop::where('id', $id)->update([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'type'=>$request->shopType,
                'cigarette_id'=>$request->cigarette_id,
                'area_id'=>$request->area_id,
            ]);
            ShopAttr::where('shop_id', $id)->update($request->only($this->attr));
            return back()->with('success', '店铺修改成功');
        } catch (Exception $e) {
            return back()->with('error', '店铺修改失败,店铺名重复!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    //删除单个店铺
    public function remove($id)
    {
        $name = Shop::find($id)->name;
        Shop::find($id)->delete($id);

        return back()->with('success', $name . '删除成功');
    }

    //删除多个店铺
    public function delete(Request $request)
    {
        Shop::whereIn('id', $request->id)->delete();
        Session::flash('success', '批量删除成功');
    }

    //将多个店铺列入黑名单
    public function black(Request $request)
    {
        ShopAttr::whereIn('shop_id', $request->id)->update(['black' => 1]);
        Session::flash('success', '批量添加黑名单成功');
    }

    //将多个店铺列入白名单
    public function white(Request $request)
    {
        ShopAttr::whereIn('shop_id', $request->id)->update(['black' => 0]);
        Session::flash('success', '批量添加白名单成功');
    }

    //设置当前页面店铺显示条数
    public function setPage($page)
    {
        session(['page' => $page]);

        return back();
    }

    //显示单个店铺的信息
    public function profile($id)
    {
        $wechat = app('wechat');
        $qrcode = $wechat->qrcode;
        $qrcode_image = $qrcode->url($qrcode->forever($id)->ticket);
//        $url = $result->url; //url是二维码扫码后的跳转地址
//        $ticket = $result->ticket;//ticket是获取二维码图片的钥匙

        $shop = Shop::with('shop_addresses','shop_attrs','shop_managers')->find($id);

        return view('admin.shop-profile', [
            'shop' => $shop,
            'qrcode_image'=>$qrcode_image,
        ]);
    }

    //添加地区
    public function setArea(Request $request)
    {
        if($request->area != null && !ShopArea::where("area",$request->area)->exists()){
            ShopArea::create([
                'area'=>$request->area,
            ]);
            return back()->with('success','地区添加成功！');
        }else{
            return back()->with('error','您未提交任何地区或者该地区已经存在');
        }
    }
}
