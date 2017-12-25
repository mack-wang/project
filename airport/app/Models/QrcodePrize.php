<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QrcodePrize
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $count
 * @property int|null $send_out
 * @property int|null $cost 消耗的礼品券数量
 * @property int|null $type 0 是专门供应兑奖券换的二维码奖品 1 是专门供应抽奖用的奖品
 * @property int|null $expire 二维码有效期 单位秒
 * @property int|null $off 0 开启 1 闭关
 * @property string|null $image_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereSendOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePrize whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QrcodePrize extends Model
{
      protected $guarded = [];
}
