<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ScanResult
 *
 * @property int $qrcode_id
 * @property int|null $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanResult whereQrcodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScanResult whereUserId($value)
 * @mixin \Eloquent
 */
class ScanResult extends Model
{
    protected $guarded = [];
}
