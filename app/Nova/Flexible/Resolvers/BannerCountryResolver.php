<?php

namespace App\Nova\Flexible\Resolvers;

use Whitecube\NovaFlexibleContent\Value\ResolverInterface;

class BannerCountryResolver implements ResolverInterface
{
    /**
     * get the field's value
     *
     * @param  mixed  $resource
     * @param  string $attribute
     * @param  \Whitecube\NovaFlexibleContent\Layouts\Collection $layouts
     * @return \Illuminate\Support\Collection
     */
    public function get($resource, $attribute, $layouts)
    {
        $countries = $resource->countries()->get();
        return $countries->map(function ($country) use ($layouts) {
            $layout = $layouts->find('countries');

            if (!$layout) return;
            $countryArray = $country->toArray();

            return $layout->duplicateAndHydrate($country->id, $countryArray['pivot']);
        })->filter();
    }

    /**
     * Set the field's value
     *
     * @param  mixed  $model
     * @param  string $attribute
     * @param  \Illuminate\Support\Collection $groups
     * @return string
     */
    public function set($model, $attribute, $groups)
    {
        $class = get_class($model);

        $class::saved(function ($model) use ($groups) {
            $countries = $groups->map(function ($group, $index) {
                $country = $group->getAttributes();

                $countryName = \App\Country::find($country['country_id'])->name;
                $country['currency'] = config('countries')[$countryName]['currency'];

                return [$country['country_id'] =>
                    [
                        'currency' => $country['currency'],
                    ]
                ];
            });
            $countriesByCountryId = [];
            foreach ($countries as $country) {
                foreach ($country as $countryId => $values) {
                    $countriesByCountryId[$countryId] = $values;
                }
            }
            if ($countriesByCountryId) {
                $model->countries()->sync($countriesByCountryId);
            }
        });
    }
}
