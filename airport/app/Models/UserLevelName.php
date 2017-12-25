<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserLevelName
 *
 * @property int $id
 * @property string $name level和id对应的等级名字
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserLevelName whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserLevelName whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserLevelName whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserLevelName whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserLevelName extends Model
{
    //
    protected $guarded=[];
}
