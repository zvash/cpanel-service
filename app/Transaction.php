<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int service_id
 * @property int action_id
 * @property float|int amount
 * @property integer user_id
 * @property string source_type
 * @property null|int source_id
 * @property null|string description
 * @property null|string|array extra_params
 * @property string currency
 * @property string due_date
 */
class Transaction extends Billing
{
    protected $casts = [
        'due_date' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * @return BelongsTo
     */
    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
