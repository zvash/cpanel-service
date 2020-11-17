<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Techouse\SelectAutoComplete\SelectAutoComplete as Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Transaction extends Resource
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
    public static $model = \App\Transaction::class;

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

            BelongsTo::make('Service', 'service', 'App\Nova\Service')
                ->sortable()->creationRules('required'),

            BelongsTo::make('Action', 'action', 'App\Nova\Action')
                ->sortable()->creationRules('required'),

            BelongsTo::make('User Phone', 'user', 'App\Nova\User')
                ->sortable()->creationRules('required'),

            Text::make('Source Type', 'source_type')->creationRules('required')
                ->withMeta(['extraAttributes' => [
                    'readonly' => true
                ]])->default(function ($request) {
                    return 'admins';
                }),

            Text::make('Source ID', 'source_id')->creationRules('required')
                ->withMeta(['extraAttributes' => [
                    'readonly' => true
                ]])->default(function ($request) {
                    return Auth::user()->id;
                }),

            Currency::make('Amount', 'amount')->creationRules('required'),

            Select::make('Currency', 'currency')->options(
                collect(config('countries'))->pluck('currency', 'currency')->unique()->toArray()
            )->onlyOnForms()->displayUsingLabels()->creationRules('required'),

            Text::make('Currency', 'currency')->showOnIndex()->showOnDetail(),

            DateTime::make('Due Date', 'due_date')
                ->creationRules('required')
                ->sortable(),

            Text::make('Description', 'description')
                ->showOnDetail()
                ->showOnCreating()
                ->showOnUpdating(),

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
