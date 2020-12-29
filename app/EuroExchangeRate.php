<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EuroExchangeRate extends GameDB
{
    protected $fillable = ['currency', 'rate'];
}
