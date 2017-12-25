<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShopAttr
 *
 * @property int $id
 * @property int $shop_id
 * @property string $type 店铺类别A B C
 * @property string $level 店铺等级 自定义
 * @property int $scores 店铺分数
 * @property bool $black 1 为黑名单
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Shop $shops
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereBlack($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereScores($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAttr whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShopAttr extends Model
{
    //
    protected $guarded = [];
    public function shops()
    {
        return $this->belongsTo('App\Models\Shop','shop_id','id');
    }
}
