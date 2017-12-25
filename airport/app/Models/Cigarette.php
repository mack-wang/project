<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cigarette
 *
 * @property int $id
 * @property string $cigarette
 * @property string $type
 * @property string $size
 * @property string $tar
 * @property string $nicotine
 * @property string $carbon
 * @property string $packet_code
 * @property string $carton_code
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereCarbon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereCartonCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereCigarette($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereNicotine($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette wherePacketCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereTar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cigarette whereType($value)
 * @mixin \Eloquent
 */
class Cigarette extends Model
{
    //
    protected $guarded=[];
}
