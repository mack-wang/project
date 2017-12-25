<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterFormRequest;
use App\Models\CigaretteLabel;
use App\Models\Shop;
use App\Models\ShopManager;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserRecommend;
use App\Models\UserWechat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Vinkla\Hashids\Facades\Hashids;

class RegisterController extends Controller
{
    //
    public function index($phone)
    {
        $user = UserWechat::where('user_id', session('user_id'))->first();
        return view('wechat.login.register', [
            'user' => $user,
            'phone' => $phone,
        ]);
    }

    public function register(UserRegisterFormRequest $request)
    {
        $id = session('user_id');

        //可以往request的结果集中添加变量
        $request->request->add(['user_id' => $id]);

        //将用户提交的表单写入数据库，如果用户没有填写，也会创建一条空的数据
        UserInfo::create($request->only([
            'user_id',
            'phone',
        ]))->user_cigarettes()->create($request->only([
            'age',
            'brand',
            'expect',
            'price',
        ]))->user_attrs()->create($request->only([
            'real_name',
            'age',
        ]))->user_addresses()->create($request->only([
            'mail_phone',
            'province',
            'city',
            'area',
            'address',
        ]))->grass_attrs()->create([
            'water' => 600,
            'seed' => 1,
        ])->grasses()->create([
            'water' => 0,
            'total' => 1000,
            'updated_at' => date("Y-m-d H:i:s", strtotime("-1 day")),
        ]);

        //label_id 0为常抽品牌，1为期望获得的测评品牌
        if ($request->brand_id) {
            foreach (str_getcsv($request->brand_id) as $cigarette_id) {
                CigaretteLabel::create([
                    'user_id' => $id,
                    'cigarette_id' => $cigarette_id,
                    'label_id' => 0,
                ]);
            }
        }

        if ($request->expect_id) {
            foreach (str_getcsv($request->expect_id) as $cigarette_id) {
                CigaretteLabel::create([
                    'user_id' => $id,
                    'cigarette_id' => $cigarette_id,
                    'label_id' => 1,
                ]);
            }
        }

        $user = User::find($id);

        $user->update([
            'register' => 1,
        ]);

        //如果该用户是管理员，则自动创建管理员账号
        if(Shop::where('phone',$request->phone)->exists()){
            $shop = Shop::where('phone',$request->phone)->first();
            ShopManager::create([
                'shop_id'=>$shop->id,
                'user_id'=>$id,
                'manager_name'=>$request->real_name,
                'phone'=>$request->phone,
            ]);

            //不管这个用户之前绑定了哪家或者有没有绑定，都给他绑定到管理员店上。
            $user->update([
                'shop_id'=>$shop->id,
            ]);
        }

        $code = $request->recommend_code;
        if ($code !== null) {
            $arr = Hashids::connection('recommend')->decode($code);
            if (!empty($arr)) {
                $recommend_id = $arr[0];
                if (User::find($recommend_id)->exists()) {
                    //推荐码可用，但暂时不给奖励
//                    UserRecommend::create([
//                        'user_id' => $id,
//                        'recommend_id' => $recommend_id,
//                    ])->user_infos()->increment('ticket');
//
//                    UserInfo::where('user_id', $recommend_id)
//                        ->first()
//                        ->increment('ticket');
                    Session::flash('success', '推荐码有效');
                }
            } else {
                Session::flash('error', '推荐码错误');
            }

        }

        Auth::guard('wechat')->login($user, true);
        return redirect('/wechat/home');
    }
}
