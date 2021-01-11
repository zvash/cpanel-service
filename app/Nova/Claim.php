<?php

namespace App\Nova;

use App\Nova\Filters\AcceptedClaim;
use App\Nova\Filters\ClaimType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Claim extends Resource
{
    /**
     * @var string
     */
    public static $group = 'Affiliate';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Claim::class;

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
     * @param Request $request
     * @return bool
     */
    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            BelongsTo::make('User Phone', 'user', 'App\Nova\User')
                ->sortable()
                ->withMeta([
                    'extraAttributes' => [
                        'readonly' => true
                    ]
                ]),

            Text::make('Claimable Type', 'claimable_type')
                ->withMeta([
                    'extraAttributes' => [
                        'readonly' => true
                    ]
                ])->sortable()->creationRules('required'),

            Text::make('Claimable ID', 'claimable_id')
                ->withMeta([
                    'extraAttributes' => [
                        'readonly' => true
                    ]
                ])->sortable()->creationRules('required'),

            Text::make('Remote ID', 'remote_id')->sortable(),

            Text::make('Token', 'token')
                ->withMeta([
                    'extraAttributes' => [
                        'readonly' => true
                    ]
                ])->sortable()->creationRules('required')->onlyOnDetail(),

            Boolean::make('Is Accepted', 'accepted')->sortable()->creationRules('required'),

            Text::make('Claimed At', 'claimed_at')
                //->creationRules('required')
                ->sortable()
                ->withMeta([
                    'extraAttributes' => [
                        'readonly' => true
                    ]
                ]),
        ];
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
            new ClaimType(),
            new AcceptedClaim()
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
