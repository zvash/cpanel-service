<?php

namespace App\Nova\Flexible\Resolvers;

use Whitecube\NovaFlexibleContent\Value\ResolverInterface;

class TaskImageResolver implements ResolverInterface
{
    /**
     * get the field's value
     *
     * @param  mixed  $resource
     * @param  string $attribute
     * @param  \Whitecube\NovaFlexibleContent\Layouts\Collection $layouts
     * @return \Illuminate\Support\Collection
     */
    public function get($resource, $attribute, $layouts)
    {
        $images = $resource->taskImages()->get();

        return $images->map(function($image) use ($layouts) {
            $layout = $layouts->find('images');

            if(!$layout) return;

            return $layout->duplicateAndHydrate($image->id, ['url' => $image->url]);
        })->filter();
    }

    /**
     * Set the field's value
     *
     * @param  mixed  $model
     * @param  string $attribute
     * @param  \Illuminate\Support\Collection $groups
     * @return string
     */
    public function set($model, $attribute, $groups)
    {
        $class = get_class($model);

        $class::saved(function ($model) use ($groups) {
            $images = $groups->map(function ($group, $index) {
                $image = $group->getAttributes();
                return $image['url'];
            });

            foreach ($images as $url) {
                $taskImage = ['task_id' => $model->id, 'url' => $url];
                \App\TaskImage::create($taskImage);
            }
        });
    }
}
