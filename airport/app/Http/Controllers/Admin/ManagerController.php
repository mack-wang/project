<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopArea;
use App\Models\ShopManager;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ManagerController extends Controller
{
    //显示所有店铺管理员
    public function index()
    {
        $managers = ShopManager::with('user_wechats', 'shops')
            ->paginate(Helper::page());

        return view('admin.manager', ['managers' => $managers]);
    }

    //根据搜索的参数，来显示所有店铺管理员
    public function search($key, $value)
    {
        //根据地区，返回店铺管理员
        $managers = $this->searchKey($key, $value)
            ->with('user_wechats', 'shops')
            ->paginate(Helper::page());

        return view('admin.manager', [
            'managers' => $managers,
            'key' => $key,
            'value' => $value
        ]);
    }

    public function searchKey($key, $value)
    {
        switch ($key) {
            case 'area_id':
                return ShopManager::whereHas('shops', function ($query) use ($value) {
                    $query->where('area_id', '=', $value);
                });
                break;
            case 'name':
                return ShopManager::whereHas('shops', function ($query) use ($value) {
                    $query->where('name', 'like', "%$value%");
                });
                break;
            case 'nickname':
                return ShopManager::whereHas('user_wechats', function ($query) use ($value) {
                    $query->where('nickname', 'like', "%$value%");
                });
                break;
            default :
                return ShopManager::where($key, $value);
        }
    }


    public function excel($key = null, $value = null)
    {
        //根据地区，返回店铺管理员
        Excel::create($value . '终端管理员表格' . date("Y-m-d"), function ($excel) use ($key, $value) {

            $excel->sheet('Sheetname', function ($sheet) use ($key, $value) {

                $areas = ShopArea::get(['id', 'area'])
                    ->keyBy('id')
                    ->toArray();

                if ($key == null) {
                    $managers = ShopManager::with('user_wechats', 'shops')
                        ->get()
                        ->toArray();
                } else {
                    $managers = $this->searchKey($key, $value)
                        ->with('user_wechats', 'shops')
                        ->get()
                        ->toArray();
                }

                $data = [];

                $title = [
                    '管理员编号',
                    '管理员名字',
                    '微信昵称',
                    '手机号',
                    '终端',
                    '烟草证号',
                    '地区',
                    '权限',
                    '创建时间',
                    '更新时间',
                ];

                foreach ($managers as $manager) {
                    array_push($data, [
                        $manager['id'],
                        $manager['manager_name'],
                        $manager['user_wechats']['nickname'],
                        $manager['phone'],
                        $manager['shops']['name'],
                        $manager['shops']['cigarette_id'],
                        $areas[$manager['shops']['area_id']]['area'],
                        $manager['phone'] == $manager['shops']['phone'] ? '负责人' : null,
                        $manager['created_at'],
                        $manager['updated_at'],
                    ]);
                }

                $sheet->appendRow($title);
                $sheet->rows($data);
            });
        })->download('xls');

    }


    //删除并拉黑单个店铺管理员
    public function remove($id)
    {
        ShopManager::find($id)->delete();

        return back()->with('success', '拉黑成功!');
    }

    //恢复单个店铺管理员
    public function white(Request $request)
    {
        ShopManager::where('phone', $request->phone)->restore();

        return back()->with('success', '管理员恢复成功!');
    }


}
