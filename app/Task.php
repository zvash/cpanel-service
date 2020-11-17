<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class Task extends TaskFeed
{

    protected $fillable = [
        'title',
        'category_id',
        'offer_id',
        'destination_url',
        'coupon_code',
        'expires_at',
        'description',
        'coin_reward',
        'custom_attributes',
        'store',
        'image',
        'token',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'prices' => FlexibleCast::class,
        'tags' => FlexibleCast::class,
        'images' => FlexibleCast::class,

    ];

    protected $appends = [
        'all_tags'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @param int $length
     * @return string
     */
    public static function generateToken($length = 5)
    {
        $token = Str::random($length);
        if (Task::where('token', $token)->first()) {
            return static::generateToken($length);
        }
        return $token;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskImages()
    {
        return $this->hasMany(TaskImage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_task');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function countries()
    {
        return $this->belongsToMany(Country::class, 'country_tasks')->withPivot([
            'currency',
            'original_price',
            'payable_price',
            'has_shipment',
            'shipment_price'
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prices()
    {
        return $this->hasMany(CountryTask::class, 'task_id', 'id');
    }

    /**
     * @param string $value
     * @return bool|string
     */
    public function getDestinationUrlAttribute(?string $value)
    {
        if (!$value) {
            return $value;
        }
        return base64_decode($value);
    }

    /**
     * @param string $value
     */
    public function setDestinationUrlAttribute(?string $value)
    {
        if ($value) {
            $this->attributes['destination_url'] = base64_encode($value);
        }
    }

    /**
     * @param string|null $value
     * @return mixed|string
     */
    public function getCustomAttributesAttribute($value)
    {
        if (!$value || is_array($value)) {
            return $value;
        }
        return json_decode($value);
    }

    /**
     * @param $value
     */
    public function setCustomAttributesAttribute($value)
    {
        if ($value && is_array($value)) {
            $this->attributes['custom_attributes'] = json_encode($value);
        }
    }

    /**
     * @return string
     */
    public function getAllTagsAttribute()
    {
        return implode(', ', $this->tags()->pluck('name')->toArray());
    }
}
