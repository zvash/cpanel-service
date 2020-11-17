<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Billing
{
    protected $fillable = ['name', 'action_type', 'currency_type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services()
    {
        return $this->belongsToMany(
            Service::class,
            'service_actions'
        );
    }
}
