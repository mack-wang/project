<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Qrcodes
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $shop_id 用户绑定的店铺
 * @property int|null $prize_id 奖品的id
 * @property int|null $state 0 未兑奖 1 已经兑奖
 * @property string|null $start_at 二维码开启时间
 * @property string|null $end_at 二维码失效时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\QrcodePath $qrcode_paths
 * @property-read \App\Models\QrcodePrize $qrcode_prizes
 * @property-read \App\Models\Shop $shops
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes wherePrizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Qrcodes whereUserId($value)
 * @mixin \Eloquent
 */
class Qrcodes extends Model
{
    public $table = 'qrcodes';

    protected $guarded = [];

    public function qrcode_prizes()
    {
        return $this->hasOne('App\Models\QrcodePrize','id','prize_id');
    }
    public function qrcode_paths()
    {
        return $this->hasOne('App\Models\QrcodePath','qrcode_id','id');
    }
    public function shops()
    {
        return $this->hasOne('App\Models\Shop','id','shop_id');
    }

}
