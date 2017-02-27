<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    // 一个人有多个quote
    public function quotes()
    {
        return $this->hasMany('App\Quote');
    }
}
