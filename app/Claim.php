<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string claimable_type
 * @property int claimable_id
 */
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

    protected $appends = [
        'claimable_url'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getClaimableUrlAttribute()
    {
        $name = '-';
        if ($this->claimable_type == 'tasks') {
            $url = '/nova/resources/tasks/' . $this->claimable_id;
            $name = 'Clicked Task';
        } else if ($this->claimable_type == 'referrals') {
            $url = '/nova/resources/users/' . $this->claimable_id;
            $name = 'Referred User';
        } else {
            $url = '/';
        }
        return "<a href='{$url}' class='no-underline font-bold dim text-primary'>{$name}</a>";
    }
}
