<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Techouse\SelectAutoComplete\SelectAutoComplete as Select;
use Treestoneit\Html\Html;
use Titasgailius\SearchRelations\SearchesRelations;

class Game extends Resource
{
    use SearchesRelations;
    /**
     * @var string
     */
    public static $group = 'Game';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Game::class;

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
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'auth.users' => ['phone'],
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
     * @param Request $request
     * @return bool
     */
    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function authorizedToUpdate(Request $request)
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
        $currencies = collect(config('countries'))->pluck('currency', 'currency')->unique()->toArray();
        $currencies['COIN'] = 'COIN';

        return [
            ID::make(__('ID'), 'id')->sortable(),

            BelongsTo::make('User Phone', 'user', 'App\Nova\User')
                ->sortable(),

            Text::make('Current Level', 'current_level_index'),

            Text::make('Total Levels', 'total_levels'),

            Text::make('State', 'state'),

            Select::make('Currency', 'currency')->options($currencies)
                ->onlyOnForms()
                ->displayUsingLabels()
                ->creationRules('required'),

            Text::make('Currency', 'currency')
                ->showOnIndex()
                ->showOnDetail()
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            Currency::make('Paid Prize', 'paid_prize'),

            Boolean::make('Is Active', 'is_active')->sortable(),

            Boolean::make('Is Expired', 'is_expired')->sortable(),

            Text::make('Transaction IDs', 'transaction_ids')->onlyOnIndex(),

            Html::make('Transaction IDs', 'transactions')->onlyOnDetail(),

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
