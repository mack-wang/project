<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shop
 *
 * @property int $id
 * @property string $name
 * @property string $phone 店铺的老板
 * @property string $cigarette_id
 * @property int $area_id
 * @property string $type apply 是测评活动 kill 是秒杀活动 airport 是机场活动 shop 是终端活动 wed婚庆活动 5 其他活动1 6 其他活动2
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ShopAddress $shop_addresses
 * @property-read \App\Models\ShopArea $shop_areas
 * @property-read \App\Models\ShopAttr $shop_attrs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShopManager[] $shop_managers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop whereAreaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop whereCigaretteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Shop extends Model
{
    //
    protected $guarded = [];
    public function shop_addresses()
    {
        return $this->hasOne('App\Models\ShopAddress');
    }
    public function shop_attrs()
    {
        return $this->hasOne('App\Models\ShopAttr','shop_id','id');
    }
    public function shop_areas()
    {
        return $this->belongsTo('App\Models\ShopArea','area_id','id');
    }
    public function shop_managers()
    {
        return $this->hasMany('App\Models\ShopManager');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function delete()
    {
        $this->shop_addresses()->delete();
        $this->shop_attrs()->delete();
        $this->shop_managers()->forceDelete();
        $this->users()->delete();
        parent::delete();
    }
}
