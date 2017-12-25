<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PostPrize
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $prize_id
 * @property int|null $status 1为已经邮寄，0为未邮寄
 * @property string|null $tracking_number 快递单号
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostPrize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostPrize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostPrize wherePrizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostPrize whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostPrize whereTrackingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostPrize whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostPrize whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\QrcodePrize $qrcode_prizes
 * @property-read \App\Models\UserAddress $user_addresses
 * @property-read \App\Models\UserAttr $user_attrs
 * @property-read \App\Models\UserInfo $user_infos
 * @property-read \App\Models\UserWechat $user_wechats
 * @property-read \App\Models\User $users
 */
class PostPrize extends Model
{
    protected $guarded = [];

    public function qrcode_prizes()
    {
        return $this->hasOne('App\Models\QrcodePrize', 'id', 'prize_id');
    }

    public function user_infos()
    {
        return $this->hasOne('App\Models\UserInfo', 'user_id', 'user_id');
    }

    public function user_wechats()
    {
        return $this->hasOne('App\Models\UserWechat', 'user_id', 'user_id');
    }

    public function user_attrs()
    {
        return $this->hasOne('App\Models\UserAttr', 'user_id', 'user_id');
    }

    public function users()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function user_addresses()
    {
        return $this->hasOne('App\Models\UserAddress', 'user_id', 'user_id');
    }

    public function result_charge_buys()
    {
        return $this->hasOne('App\Models\ResultChargeBuy', 'serialno', 'id');
    }

    public function result_charge_callbacks()
    {
        return $this->hasOne('App\Models\ResultChargeCallback', 'downstreamSerialno', 'id');
    }
}
