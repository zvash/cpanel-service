<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class BulkTask extends Resource
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
    public static $model = \App\BulkTask::class;

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
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make('Description', 'description')->creationRules('required'),

            File::make('CSV', 'csv_file')
                ->showOnDetail()
                ->showOnCreating()
                ->showOnUpdating()
                ->rules('required', 'file', 'mimes:csv,txt')
                ->storeAs(function (Request $request) {
                    $random = mt_rand(100000, 99999999);
                    $now = microtime();
                    return sha1("$random-$now") . '.csv';
                }),

            Text::make('CSV', 'csv_file')->onlyOnIndex(),

            File::make('Images Zip File', 'images_zip_file')
                ->showOnDetail()
                ->showOnCreating()
                ->showOnUpdating()
                ->rules('nullable', 'mimes:zip'),

            Text::make('Images Zip File', 'images_zip_file')->onlyOnIndex(),

            Boolean::make('Is Activated', 'is_activated')->creationRules('required'),

            Text::make('Status', 'status')->creationRules('required')
                ->withMeta(['extraAttributes' => [
                    'readonly' => true
                ]])->default(function ($request) {
                    return 'pending';
                }),

            Text::make('Result', 'result')->withMeta(['extraAttributes' => [
                'readonly' => true
            ]])->default(function ($request) {
                return '';
            }),
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
        return [];
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
