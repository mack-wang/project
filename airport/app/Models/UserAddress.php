<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserAddress
 *
 * @property int $id
 * @property int $user_id
 * @property string $mail_phone
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\UserAttr $user_attrs
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereArea($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereMailPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereProvince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\GrassAttr $grass_attrs
 */
class UserAddress extends Model
{
    //
    protected $guarded = [];

    public function user_attrs()
    {
        return $this->hasOne('App\Models\UserAttr', 'user_id', 'user_id');
    }

    public function grass_attrs()
    {
        return $this->hasOne('App\Models\GrassAttr', 'user_id', 'user_id');
    }
}
