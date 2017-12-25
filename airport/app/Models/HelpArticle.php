<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpArticle extends Model
{
    protected $guarded = [];

    public function articles()
    {
        return $this->hasOne('App\Models\Article','id','article_id');
    }
}
