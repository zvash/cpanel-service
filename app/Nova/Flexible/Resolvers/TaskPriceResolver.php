<?php

namespace App\Nova\Flexible\Resolvers;

use App\Country;
use Whitecube\NovaFlexibleContent\Value\ResolverInterface;

class TaskPriceResolver implements ResolverInterface
{
    /**
     * get the field's value
     *
     * @param  mixed $resource
     * @param  string $attribute
     * @param  \Whitecube\NovaFlexibleContent\Layouts\Collection $layouts
     * @return \Illuminate\Support\Collection
     */
    public function get($resource, $attribute, $layouts)
    {
        $prices = $resource->prices()->get();

        return $prices->map(function ($price) use ($layouts) {
            $layout = $layouts->find('prices');

            if (!$layout) return;
            $priceArray = $price->toArray();
            return $layout->duplicateAndHydrate($price->id, $priceArray);
        })->filter();
    }

    /**
     * Set the field's value
     *
     * @param  mixed $model
     * @param  string $attribute
     * @param  \Illuminate\Support\Collection $groups
     * @return string
     */
    public function set($model, $attribute, $groups)
    {
        $class = get_class($model);

        $class::saved(function ($model) use ($groups) {
            $prices = $groups->map(function ($group, $index) {
                $price = $group->getAttributes();

                $countryName = \App\Country::find($price['country_id'])->name;
                $price['currency'] = config('countries')[$countryName]['currency'];

                return [$price['country_id'] =>
                    [
                        'currency' => $price['currency'],
                        'payable_price' => $price['payable_price'],
                        'original_price' => $price['original_price'] ?? $price['payable_price'],
                        'has_shipment' => $price['has_shipment'],
                        'shipment_price' => $price['has_shipment'] ? $price['shipment_price'] : 0
                    ]
                ];
            });
            $pricesByCountryId = [];
            foreach ($prices as $price) {
                foreach ($price as $countryId => $values) {
                    $pricesByCountryId[$countryId] = $values;
                }
            }
            if ($pricesByCountryId) {
                $model->countries()->sync($pricesByCountryId);
            }
        });
    }
}
