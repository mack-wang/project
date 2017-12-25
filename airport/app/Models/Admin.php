<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $remember_token
 * @property string $headimgurl
 * @property bool $auth
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereAuth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereHeadimgurl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Admin extends Authenticatable
{
    //
    protected $fillable = [
        'name', 'email', 'phone','password','headimgurl'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
