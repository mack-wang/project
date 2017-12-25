<?php

namespace App;

class Helper
{
    public static function getAddress($user_id)
    {
        $address = UserAddress::where('user_id', $user_id)->first();
        if ($address) {
            $address_str = City::find($address->province)->name
                . City::find($address->city)->name
                . City::find($address->area)->name
                . $address->address;

            return $address_str;
        } else {
            return '未填写';

        }

    }
}
