<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CigaretteLabel
 *
 * @property int $id
 * @property int $user_id
 * @property int $cigarette_id
 * @property bool $label_id 0 为常抽的品牌 1为期望的品牌
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigaretteLabel whereCigaretteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigaretteLabel whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigaretteLabel whereLabelId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigaretteLabel whereUserId($value)
 * @mixin \Eloquent
 */
class CigaretteLabel extends Model
{
    //
    protected $guarded = [];
    public $timestamps = false;
}
