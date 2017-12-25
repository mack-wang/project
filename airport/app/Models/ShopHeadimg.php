<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShopHeadimg
 *
 * @property int $shop_id
 * @property string $image_path 店铺头像
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopHeadimg whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopHeadimg whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopHeadimg whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopHeadimg whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShopHeadimg extends Model
{
    protected $guarded = [];
    public $primaryKey = 'shop_id';
}
