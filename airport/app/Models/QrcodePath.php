<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QrcodePath
 *
 * @property int $qrcode_id
 * @property string|null $qrcode_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $hashids
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePath whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePath whereHashids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePath whereQrcodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePath whereQrcodePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QrcodePath whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QrcodePath extends Model
{
    protected $guarded = [];
}
