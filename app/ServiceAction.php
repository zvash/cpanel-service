<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceAction extends Billing
{
    protected $table = 'service_actions';

    protected $fillable = ['service_id', 'action_id'];
}
