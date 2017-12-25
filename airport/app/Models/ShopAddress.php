<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShopAddress
 *
 * @property int $id
 * @property int $shop_id
 * @property int $manager_id
 * @property string $mail_phone
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereArea($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereMailPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereManagerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereProvince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShopAddress whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShopAddress extends Model
{
    //
    protected $guarded = [];


}
