<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialProof extends GameDB
{
    protected $fillable = [
        'user_id',
        'play_count',
        'won_amount',
        'currency',
        'comment',
        'visible',
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
