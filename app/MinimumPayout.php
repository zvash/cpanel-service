<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MinimumPayout extends Billing
{
    protected $fillable = [
        'amount',
        'currency'
    ];

    /**
     * @var double $defaultAmount
     */
    private static $defaultAmount = 10;

    /**
     * @param string $currency
     * @return int
     */
    public static function getMin(string $currency)
    {
        $minPayout = MinimumPayout::where('currency', $currency)->first();
        if ($minPayout) {
            return $minPayout->amount;
        }
        return static::$defaultAmount;
    }
}
