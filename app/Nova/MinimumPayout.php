<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Techouse\SelectAutoComplete\SelectAutoComplete as Select;

class MinimumPayout extends Resource
{
    /**
     * @var string
     */
    public static $group = 'Billing';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\MinimumPayout::class;

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
        $currencies = collect(config('countries'))->pluck('currency', 'currency')->unique()->toArray();

        return [
            ID::make(__('ID'), 'id')->sortable(),

            Currency::make('Minimum Amount', 'amount')->creationRules('required'),

            Select::make('Currency', 'currency')->options($currencies)
                ->onlyOnForms()
                ->displayUsingLabels()
                ->creationRules('required'),

            Text::make('Currency', 'currency')
                ->showOnIndex()
                ->showOnDetail()
                ->hideWhenUpdating()
                ->hideWhenCreating(),
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
