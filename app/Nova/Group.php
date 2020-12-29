<?php

namespace App\Nova;

use App\Nova\Filters\GroupType;
use App\Nova\Flexible\Resolvers\GroupTagResolver;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

class Group extends Resource
{
    /**
     * @var string
     */
    public static $group = 'Task Feed';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Group::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $sort = [
        'order' => 'asc'
    ];

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if (empty($request->get('orderBy'))) {
            $query->getQuery()->orders = [];

            return $query->orderBy(key(static::$sort), reset(static::$sort));
        }

        return $query;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        $tags = \App\Tag::all()->pluck('name', 'id')->toArray();

        try {
            return [
                ID::make(__('ID'), 'id')->sortable(),
                Text::make('Name', 'name')
                    ->creationRules('required', 'string')->sortable(),
                Select::make('Type', 'type')->options([
                    'tasks' => 'Tasks',
                    'banners' => 'Banners'
                ])
                    ->creationRules('required')
                    ->displayUsingLabels(),
                Boolean::make('Is Active', 'is_active')->creationRules('required')->sortable(),
                Number::make('Order', 'order')->min(1)->step(1)->creationRules('required')->sortable(),

                Text::make('All Tags', 'all_tags')->onlyOnDetail(),

                Flexible::make('Tags', 'tags')
                    ->addLayout('Tag', 'tags', [
                        Select::make('Tag', 'id')->options(
                            $tags
                        )->displayUsingLabels()->creationRules('required'),
                    ])
                    ->fullWidth()
                    ->onlyOnForms()
                    ->button('Add Tag')->resolver(GroupTagResolver::class),
            ];
        } catch (\Exception $e) {
        }
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new GroupType(),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
