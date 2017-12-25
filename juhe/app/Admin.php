<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $remember_token
 * @property string $avatar
 * @property bool $auth
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereAuth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
