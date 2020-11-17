<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends TaskFeed
{
    protected $fillable = ['name', 'is_active', 'type', 'order'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = [
        'all_tags'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'group_tags');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function banners()
    {
        return $this->hasMany(Banner::class);
    }

    /**
     * @return string
     */
    public function getAllTagsAttribute()
    {
        return implode(', ', $this->tags()->pluck('name')->toArray());
    }
}
