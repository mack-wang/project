<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserAttr
 *
 * @property int $id
 * @property int $user_id
 * @property string $real_name
 * @property string $email
 * @property string $id_card
 * @property bool $age
 * @property string $job
 * @property int $income 平均每月收入
 * @property string $education
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereAge($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereEducation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereIdCard($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereIncome($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereJob($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereRealName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAttr whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\UserAddress $user_addresses
 */
class UserAttr extends Model
{
    //
    protected $table = 'user_attrs';
    protected $guarded = [];
    public function user_addresses()
    {
        return $this->hasOne('App\Models\UserAddress','user_id','user_id');
    }
}
