<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payout extends Billing
{
    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'is_paid',
        'description'
    ];

    /**
     * @return BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
