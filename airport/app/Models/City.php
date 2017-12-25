<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\City
 *
 * @property int $id
 * @property string $name
 * @property bool $level
 * @property bool $usetype
 * @property int $pid
 * @property int $city
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City wherePid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereUsetype($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    //
    protected $table = 'mh_city';
    protected $guarded = [];
}
