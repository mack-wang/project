<?php

namespace App\Http\Controllers;

use App\City;
use App\User;
use App\UserAddress;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();

        $address = UserAddress::where('user_id', $id)->first();

        if ($address) {
            $address_str = City::find($address->province)->name
                . City::find($address->city)->name
                . City::find($address->area)->name
                . $address->address;
        } else {
            $address_str = null;

        }

        return view('wechat.user', [
            'user' => User::with('user_companies','user_avatars')->find($id),
            'address_str' => $address_str,
        ]);
    }
}
