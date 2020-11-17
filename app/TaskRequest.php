<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskRequest extends Model
{
    protected $fillable = [
        'category_id',
        'offer_id',
        'title',
        'store',
        'destination_url',
        'coupon_code',
        'expires_at',
        'description',
        'coin_reward',
        'custom_attributes',
        'images',
        'tags',
        'prices',
    ];

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
}
