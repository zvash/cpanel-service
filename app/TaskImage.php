<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskImage extends TaskFeed
{

    protected $fillable = ['task_id', 'url'];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

//    /**
//     * @param $value
//     * @return string
//     */
//    public function getUrlAttribute($value)
//    {
//        if ($value) {
//            return /*rtrim(env('TASKFEED_APP_URL'), '/') . */'taskfeed/' . $value;
//        }
//        return $value;
//    }

    public function setUrlAttribute($value)
    {
        if ($value) {
            $value = 'storage/images/' . preg_replace('#taskfeed#', '', $value);
            $this->attributes['url'] = $value;
        }
    }
}
