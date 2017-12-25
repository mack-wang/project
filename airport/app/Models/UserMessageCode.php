<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserMessageCode
 *
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property string $code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserMessageCode whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserMessageCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserMessageCode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserMessageCode wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserMessageCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserMessageCode whereUserId($value)
 * @mixin \Eloquent
 */
class UserMessageCode extends Model
{
    //
    protected $guarded = [];
}
