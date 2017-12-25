<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserCigarette
 *
 * @property int $id
 * @property int $user_id
 * @property bool $age
 * @property string $brand 当前在抽的品牌
 * @property string $expect 期望获得的香烟品牌
 * @property int $price 平均所抽香烟价位
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette whereAge($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette whereBrand($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette whereExpect($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserCigarette whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\UserAttr $user_attrs
 */
class UserCigarette extends Model
{
    //
    protected $guarded = [];

    public function user_attrs()
    {
        return $this->hasOne('App\Models\UserAttr','user_id','user_id');
    }
}
