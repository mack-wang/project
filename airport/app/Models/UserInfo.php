<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserInfo
 *
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property string $exp
 * @property bool $level
 * @property int $ticket
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\UserAddress $user_addresses
 * @property-read \App\Models\UserAttr $user_attrs
 * @property-read \App\Models\UserCigarette $user_cigarettes
 * @property-read \App\Models\User $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereExp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereTicket($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserInfo whereUserId($value)
 * @mixin \Eloquent
 */
class UserInfo extends Model
{
    //
    protected $guarded = [];

    public function user_cigarettes()
    {
        return $this->hasOne('App\Models\UserCigarette', 'user_id', 'user_id');
    }

    public function user_attrs()
    {
        return $this->hasOne('App\Models\UserAttr', 'user_id', 'user_id');
    }

    public function user_addresses()
    {
        return $this->hasOne('App\Models\UserAddress', 'user_id', 'user_id');
    }

    public function users()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
