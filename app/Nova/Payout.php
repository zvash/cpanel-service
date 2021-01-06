<?php

namespace App\Nova;

use Hubertnnn\LaravelNova\Fields\DynamicSelect\DynamicSelect;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Payout extends Resource
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
    public static $model = \App\Payout::class;

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
     * @param Request $request
     * @return bool
     */
    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

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

            BelongsTo::make('User Phone', 'user', 'App\Nova\User')
                ->withMeta(['extraAttributes' => [
                    'readonly' => true
                ]])
                ->sortable()->creationRules('required'),

            BelongsTo::make('Transaction', 'transaction', 'App\Nova\Transaction')
                ->withMeta(['extraAttributes' => [
                    'readonly' => true
                ]])
                ->nullable()
                ->sortable(),

            Currency::make('Amount', 'amount')->creationRules('required'),

            Text::make('Currency', 'currency')
                ->showOnIndex()
                ->showOnDetail()
                ->hideWhenUpdating()
                ->hideWhenCreating(),


            Text::make('Currency', 'currency')->creationRules('required')
                ->withMeta(['extraAttributes' => [
                    'readonly' => true
                ]])->default(function ($request) {
                    return '';
                })->hideFromIndex()
                ->hideFromDetail(),



            Boolean::make('Is Paid', 'is_paid')->creationRules('required')->sortable(),

            Textarea::make('Description', 'description')
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
