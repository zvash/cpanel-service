<?php

namespace App\Nova;

use App\Country;
use App\Nova\Flexible\Resolvers\BannerCountryResolver;
use App\Nova\Flexible\Resolvers\GroupTagResolver;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Techouse\SelectAutoComplete\SelectAutoComplete as Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

class Banner extends Resource
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
    public static $model = \App\Banner::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        try {
            $tags = \App\Tag::all()->pluck('name', 'id')->toArray();
            $countries = Country::all()->pluck('name', 'id')->toArray();

            return [
                ID::make(__('ID'), 'id')->sortable(),
                BelongsTo::make('Group', 'group', 'App\Nova\Group')
                    ->sortable()->creationRules('required'),
                Text::make('Name', 'name')->sortable()->creationRules('required'),
                Image::make('Image', 'image', 'taskfeed')->creationRules('required'),

                Flexible::make('Countries', 'countries')
                    ->addLayout('Country', 'countries', [
                        Select::make('Country', 'country_id')->options(
                            $countries
                        )->displayUsingLabels()->creationRules('required'),
                    ])
                    ->fullWidth()
                    ->showOnDetail()
                    ->showOnCreating()
                    ->showOnUpdating()
                    ->button('Add Country')->resolver(BannerCountryResolver::class),

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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
