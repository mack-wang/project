<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ShopManager
 *
 * @property int $id
 * @property int $shop_id
 * @property int $user_id
 * @property string $manager_name
 * @property string $phone
 * @property string $remember_token
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ShopAddress $shop_addresses
 * @property-read \App\Models\ShopAttr $shop_attrs
 * @property-read \App\Models\Shop $shops
 * @property-read \App\Models\UserInfo $user_infos
 * @property-read \App\Models\UserWechat $user_wechats
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereManagerName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager whereUserId($value)
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopManager withoutTrashed()
 */
class ShopManager extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    //
    protected $guarded = [];
    public function shop_addresses()
    {
        return $this->hasOne('App\Models\ShopAddress','manager_id','id');
    }
    public function shop_attrs()
    {
        return $this->hasOne('App\Models\ShopAttr','shop_id','shop_id');
    }

    public function shops()
    {
        return $this->belongsTo('App\Models\Shop','shop_id','id');
    }

    public function user_wechats()
    {
        return $this->hasOne('App\Models\UserWechat','user_id','user_id');
    }

    public function user_infos()
    {
        return $this->hasOne('App\Models\UserInfo','user_id','user_id');
    }
}
