<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CigarettePrice
 *
 * @property int $cigarette_id
 * @property int $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigarettePrice whereCigaretteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigarettePrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigarettePrice wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CigarettePrice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CigarettePrice extends Model
{
    protected $guarded = [];
}
