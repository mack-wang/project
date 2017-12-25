<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserWechatInfo
 *
 * @property int $id
 * @property int $user_id
 * @property string $province
 * @property string $city
 * @property bool $sex
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\UserWechat $user_wechat_infos
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechatInfo whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechatInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechatInfo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechatInfo whereProvince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechatInfo whereSex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechatInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserWechatInfo whereUserId($value)
 * @mixin \Eloquent
 */
class UserWechatInfo extends Model
{
    //
    protected $guarded = [];

    public function user_wechat_infos()
    {
        return $this->hasOne('App\Models\UserWechat','user_id','user_id');
    }
}
