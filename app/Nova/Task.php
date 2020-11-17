<?php

namespace App\Nova;

use App\Country;
use App\Nova\Flexible\Resolvers\TaskImageResolver;
use App\Nova\Flexible\Resolvers\TaskPriceResolver;
use App\Nova\Flexible\Resolvers\TaskTagResolver;
use Chaseconey\ExternalImage\ExternalImage;
use Khalin\Nova\Field\Link;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\KeyValue;
use Techouse\SelectAutoComplete\SelectAutoComplete as Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use R64\NovaFields\JSON;
use Ramsey\Uuid\Type\Integer;
use Whitecube\NovaFlexibleContent\Flexible;

class Task extends Resource
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
    public static $model = \App\Task::class;

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
        'title',
        'category_id',
        'offer_id',
        'destination_url',
        'coupon_code',
        'expires_at',
        'description',
        'coin_reward',
        'custom_attributes',
        'store',
        'image',
        'token',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        try {
            $tags = \App\Tag::all()->pluck('name', 'id')->toArray();
            $countries = Country::all()->pluck('name', 'id')->toArray();
            return [
                ID::make(__('ID'), 'id')->sortable(),

                Text::make('Title')
                    ->sortable()
                    ->rules('required', 'max:255'),

                Text::make('Token', 'token')->creationRules('required')
                    ->withMeta(['extraAttributes' => [
                        'readonly' => true
                    ]])->default(function ($request) {
                        return \App\Task::generateToken();
                    })->hideFromIndex(),

                BelongsTo::make('Category ID', 'category', 'App\Nova\Category')
                    ->sortable()->creationRules('required'),

                Text::make('Offer ID', 'offer_id')->creationRules('required'),

                Text::make('Store')
                    ->sortable()
                    ->rules('required', 'max:255'),

                Text::make('Destination URL', 'destination_url')
                    ->sortable()
                    ->creationRules('required', 'max:255', 'url')
                    ->onlyOnForms(),

                Link::make('Destination URL', 'destination_url')
                    ->url(function () {
                        return "{$this->destination_url}";
                    })->text("Go to Store")->blank()
                    ->showOnDetail()->showOnIndex()->hideWhenCreating()->hideWhenUpdating(),

                Text::make('Coupon Code', 'coupon_code'),

                DateTime::make('Expires At', 'expires_at')
                    ->creationRules('required')
                    ->sortable(),

                Text::make('Coin Reward', 'coin_reward')
                    ->creationRules('required')
                    ->sortable(),

                Textarea::make('Description', 'description')
                    ->showOnDetail()
                    ->showOnCreating()
                    ->showOnUpdating(),

                KeyValue::make('Attributes', 'custom_attributes')
                    ->rules('json')
                    ->showOnDetail()
                    ->showOnCreating()
                    ->showOnUpdating(),

                Flexible::make('Prices', 'prices')
                    ->addLayout('Price', 'prices', [
                        Select::make('Country', 'country_id')->options(
                            $countries
                        )->displayUsingLabels()->creationRules('required'),
                        Currency::make('Payable Price', 'payable_price')->creationRules('required'),
                        Currency::make('Original Price', 'original_price')->creationRules('required'),
                        Boolean::make('Has Shipment', 'has_shipment')->creationRules('required'),
                        Currency::make('Shipment Price', 'shipment_price'),
                    ])
                    ->fullWidth()
                    ->showOnDetail()
                    ->showOnCreating()
                    ->showOnUpdating()
                    ->button('Add Price')->resolver(TaskPriceResolver::class),


                Flexible::make('Tags', 'tags')
                    ->addLayout('Tag', 'tags', [
                        Select::make('Tag', 'id')->options(
                            $tags
                        )->displayUsingLabels()->creationRules('required'),
                    ])
                    ->fullWidth()
                    ->onlyOnForms()
                    ->button('Add Tag')->resolver(TaskTagResolver::class),

                Text::make('All Tags', 'all_tags')->onlyOnDetail(),

                HasMany::make('Images', 'taskImages', 'App\Nova\TaskImage')->onlyOnDetail(),

                Flexible::make('Images', 'images')
                    ->addLayout('Image', 'images', [
                        Image::make('Image', 'url', 'taskfeed')->creationRules('required')
                    ])->fullWidth()->onlyOnForms()->button('Add Image')->resolver(TaskImageResolver::class),
            ];
        } catch (\Exception $e) {
            return [];
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
