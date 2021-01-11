<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claim extends AffiliateDB
{
    protected $fillable = [
        'user_id',
        'claimable_type',
        'claimable_id',
        'remote_id',
        'token',
        'coin_reward',
        'accepted'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
