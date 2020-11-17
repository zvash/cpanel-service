<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Banner extends TaskFeed
{

    protected $fillable = [
        'group_id',
        'name',
        'image'
    ];

    protected $appends = [
        'all_tags'
    ];

    public static function makeBanner(int $groupId, string $name, string $image)
    {
        try {
            DB::beginTransaction();
            $banner = Banner::create([
                'group_id' => $groupId,
                'name' => $name,
                'image' => $image
            ]);
            DB::commit();
            return $banner;
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'banner_tags');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function countries()
    {
        return $this->belongsToMany(Country::class, 'banner_countries')->withPivot([
            'currency'
        ]);
    }

    /**
     * @param $value
     */
    public function setImageAttribute($value)
    {
        if ($value) {
            $value = 'storage/images/' . preg_replace('#taskfeed#', '', $value);
            $this->attributes['image'] = $value;
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
