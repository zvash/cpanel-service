<?php

namespace App\Nova\Flexible\Resolvers;

use Whitecube\NovaFlexibleContent\Value\ResolverInterface;

class GroupTagResolver implements ResolverInterface
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
        $tags = $resource->tags()->get();

        return $tags->map(function($tag) use ($layouts) {
            $layout = $layouts->find('tags');

            if(!$layout) return;

            return $layout->duplicateAndHydrate($tag->id, $tag->toArray());
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
            $tags = $groups->map(function ($group, $index) {
                $tag = $group->getAttributes();
                return $tag['id'];
            });

            if ($tags) {
                $model->tags()->sync($tags);
            }
        });
    }
}
