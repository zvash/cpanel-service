<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameConfig extends GameDB
{
    protected $fillable = ['key', 'value'];
}
