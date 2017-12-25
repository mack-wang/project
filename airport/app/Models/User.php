<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property int $shop_id
 * @property string $openid
 * @property bool $register
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\GrassAttr $grass_attrs
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Models\ShopManager $shop_managers
 * @property-read \App\Models\Shop $shops
 * @property-read \App\Models\UserAddress $user_addresses
 * @property-read \App\Models\UserAttr $user_attrs
 * @property-read \App\Models\UserCigarette $user_cigarettes
 * @property-read \App\Models\UserInfo $user_infos
 * @property-read \App\Models\UserWechatInfo $user_wechat_infos
 * @property-read \App\Models\UserWechat $user_wechats
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereOpenid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRegister($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $password
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function user_addresses()
    {
        return $this->hasOne('App\Models\UserAddress');
    }
    public function user_attrs()
    {
        return $this->hasOne('App\Models\UserAttr');
    }
    public function user_infos()
    {
        return $this->hasOne('App\Models\UserInfo');
    }

    public function shops()
    {
        return $this->hasOne('App\Models\Shop','id','shop_id');
    }

    public function shop_managers()
    {
        return $this->hasOne('App\Models\ShopManager');
    }

    public function user_wechats()
    {
        return $this->hasOne('App\Models\UserWechat');
    }

    public function user_wechat_infos()
    {
        return $this->hasOne('App\Models\UserWechatInfo');
    }

    public function user_cigarettes()
    {
        return $this->hasOne('App\Models\UserCigarette');
    }

    public function grass_attrs()
    {
        return $this->hasOne('App\Models\GrassAttr');
    }

    public function delete() {
        $this->user_addresses()->delete();
        $this->user_attrs()->delete();
        $this->user_infos()->delete();
        $this->user_wechats()->delete();
        $this->user_wechat_infos()->delete();
        $this->shop_managers()->forceDelete();
        $this->user_cigarettes()->delete();
        parent::delete();
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

}
