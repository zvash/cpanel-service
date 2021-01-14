<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Techouse\SelectAutoComplete\SelectAutoComplete as Select;

class Filter extends Resource
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
    public static $model = \App\Filter::class;

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
        return [
            ID::make(__('ID'), 'id')->sortable(),

            BelongsTo::make('Filterable ID', 'filterable', 'App\Nova\Filterable')
                ->sortable()->creationRules('required'),

            Text::make('Name', 'name')->creationRules('required'),

            Select::make('Selection Type', 'selection_type')->options(
                [
                    'range' => 'Range',
                    'equals' => 'Equals',
                    'multi_select' => 'Multi Select',
                    'single_select' => 'Single Select',
                    'switch' => 'Switch'
                ]
            )->displayUsingLabels()->creationRules('required'),

            Boolean::make('Is Active', 'is_active')->sortable()->creationRules('required'),

            Number::make('Order', 'order')->min(1)->step(1)->creationRules('required')->sortable(),
        ];
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
